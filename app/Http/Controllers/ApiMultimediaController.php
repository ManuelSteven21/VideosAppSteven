<?php

namespace App\Http\Controllers;

use App\Models\Multimedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApiMultimediaController extends Controller
{
    // Obtener todos los archivos (público)
    public function index()
    {
        return Multimedia::latest()->get();
    }

    // Obtener archivos del usuario autenticado
    public function userFiles()
    {
        return auth()->user()->multimedia()->with(['user' => function($query) {
            $query->select('id', 'name');
        }])->get();
    }

    // En ApiMultimediaController.php
    public function show($id)
    {
        return Multimedia::with(['user' => function($query) {
            $query->select('id', 'name');
        }])
            ->select('*', 'user_id') // Asegúrate de incluir user_id
            ->findOrFail($id);
    }

    // Guardar nuevo archivo (protegido)
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file|max:102400' // 100MB máximo
        ]);

        try {
            $file = $request->file('file');

            if (!$file->isValid()) {
                throw new \Exception('Archivo no válido');
            }

            $path = $file->store('multimedia', 'public');
            $type = str_starts_with($file->getMimeType(), 'video/') ? 'video' : 'photo';

            $media = auth()->user()->multimedia()->create([
                'title' => $request->title,
                'description' => $request->description,
                'file_path' => $path,
                'type' => $type,
                'is_temp' => false
            ]);

            return response()->json($media, 201);

        } catch (\Exception $e) {
            \Log::error('Error en store: '.$e->getMessage());
            return response()->json([
                'message' => 'Error al subir archivo',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function hasFFmpeg()
    {
        try {
            $ffmpegPath = shell_exec('which ffmpeg');
            return !empty(trim($ffmpegPath)) && is_executable(trim($ffmpegPath));
        } catch (\Exception $e) {
            \Log::error('Error checking FFmpeg: '.$e->getMessage());
            return false;
        }
    }

    private function generateVideoThumbnail($videoFile)
    {
        try {
            if (!$this->hasFFmpeg()) {
                return null;
            }

            $thumbnailName = Str::uuid().'.jpg'; // Aquí estaba el error
            $thumbnailPath = "thumbnails/{$thumbnailName}";

            // Crear directorio si no existe
            Storage::disk('public')->makeDirectory('thumbnails');

            // Ruta temporal para el video
            $tempVideoPath = $videoFile->storeAs('temp', Str::uuid().'.mp4', 'public');

            // Generar thumbnail con FFmpeg
            $command = "ffmpeg -i ".storage_path("app/public/{$tempVideoPath}")." ".
                "-ss 00:00:01 -vframes 1 -q:v 2 ".
                storage_path("app/public/{$thumbnailPath}")." 2>&1";

            exec($command, $output, $returnCode);

            // Eliminar archivo temporal
            Storage::disk('public')->delete($tempVideoPath);

            if ($returnCode !== 0) {
                \Log::error("FFmpeg falló con código: $returnCode", ['output' => $output]);
                return null;
            }

            return Storage::disk('public')->exists($thumbnailPath) ? $thumbnailPath : null;

        } catch (\Exception $e) {
            \Log::error('Error generando thumbnail: '.$e->getMessage());
            return null;
        }
    }

    // Subida directa de archivos (para FilePond)
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimetypes:image/jpeg,image/png,video/mp4,video/quicktime,video/x-msvideo,image/webp'
        ]);

        $file = $request->file('file');
        $path = $file->store('multimedia', 'public');
        $mimeType = $file->getMimeType();
        $type = str_contains($mimeType, 'video') ? 'video' : 'photo';

        $mediaData = [
            'file_path' => $path,
            'type' => $type,
            'is_temp' => true,
            'title' => 'Temporal-'.uniqid(),
            'thumbnail_path' => null
        ];

        if ($type === 'video') {
            $mediaData['thumbnail_path'] = $this->generateVideoThumbnail($file);
        }

        $media = auth()->user()->multimedia()->create($mediaData);

        return response()->json([
            'id' => $media->id,
            'path' => $path,
            'url' => Storage::url($path),
            'thumbnail_url' => $media->thumbnail_url,
            'type' => $media->type
        ], 201);
    }

    // Confirmar subida con metadatos
    public function confirmUpload(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:500'
        ]);

        $media = auth()->user()->multimedia()
            ->where('is_temp', true)
            ->findOrFail($id);

        $media->update([
            'title' => $request->title,
            'description' => $request->description,
            'is_temp' => false
        ]);


        return response()->json($media->fresh());
    }

    // Actualizar archivo (protegido)
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000'
        ]);

        $media = auth()->user()->multimedia()->findOrFail($id);

        $media->update([
            'title' => $request->title,
            'description' => $request->description
        ]);

        return response()->json($media);
    }

    public function replaceFile(Request $request, $id)
    {
        try {
            $request->validate([
                'file' => 'required|file|mimes:jpg,jpeg,png,gif,webp,mp4,mov,avi', // 100MB max
                'thumbnail' => 'nullable|image|max:2048' // 2MB max para thumbnails
            ]);

            $media = auth()->user()->multimedia()->findOrFail($id);
            $file = $request->file('file');
            $newType = str_starts_with($file->getMimeType(), 'video/') ? 'video' : 'photo';

            // Subir nuevo archivo
            $path = $file->store('multimedia', 'public');

            // Manejar thumbnail
            $thumbnailPath = null;
            if ($newType === 'video') {
                // Usar thumbnail proporcionado o generar uno nuevo
                if ($request->hasFile('thumbnail')) {
                    $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
                } else {
                    $thumbnailPath = $this->generateVideoThumbnail($file);
                }
            } elseif ($media->thumbnail_path) {
                // Eliminar thumbnail anterior si ya no es video
                Storage::disk('public')->delete($media->thumbnail_path);
            }

            // Eliminar archivos antiguos
            Storage::disk('public')->delete($media->file_path);
            if ($media->thumbnail_path && $media->thumbnail_path !== $thumbnailPath) {
                Storage::disk('public')->delete($media->thumbnail_path);
            }

            // Actualizar registro
            $media->update([
                'file_path' => $path,
                'type' => $newType,
                'thumbnail_path' => $thumbnailPath,
                'file_size' => $file->getSize()
            ]);

            return response()->json($media->fresh());

        } catch (\Exception $e) {
            \Log::error('Error replacing file: '.$e->getMessage());
            return response()->json([
                'message' => 'Error al reemplazar el archivo',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getUserProfile()
    {
        $user = auth()->user()->loadCount([
            'multimedia',
            'multimedia as photos_count' => function($query) {
                $query->where('type', 'photo');
            },
            'multimedia as videos_count' => function($query) {
                $query->where('type', 'video');
            }
        ]);

        return response()->json([
            'user' => $user->only('id', 'name', 'email', 'avatar', 'created_at'),
            'stats' => [
                'totalFiles' => $user->multimedia_count,
                'totalPhotos' => $user->photos_count,
                'totalVideos' => $user->videos_count
            ]
        ]);
    }

    public function destroy($id)
    {
        $media = auth()->user()->multimedia()->findOrFail($id);

        // Eliminar archivos físicos
        Storage::disk('public')->delete($media->file_path);
        if ($media->thumbnail_path) {
            Storage::disk('public')->delete($media->thumbnail_path);
        }

        $media->delete();

        return response()->noContent();
    }
}
