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
        return auth()->user()->multimedia;
    }

    // Mostrar un archivo específico (público)
    public function show($id)
    {
        return Multimedia::with(['user' => function($query) {
            $query->select('id', 'name');
        }])->findOrFail($id);
    }

    // Guardar nuevo archivo (protegido)
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'file' => 'required|file'
            ]);

            \Log::info('Iniciando subida de archivo:', [
                'tamaño' => $request->file('file')->getSize(),
                'tipo_mime' => $request->file('file')->getMimeType()
            ]);

            $file = $request->file('file');
            $path = $file->store('multimedia', 'public');

            \Log::info('Archivo almacenado:', ['path' => $path]);

            $type = str_starts_with($file->getMimeType(), 'video/') ? 'video' : 'photo';

            return auth()->user()->multimedia()->create([
                'title' => $request->title,
                'description' => $request->description,
                'type' => $type,
                'file_path' => $path,
                'is_temp' => false
            ]);

        } catch (\Exception $e) {
            \Log::error('Error al subir archivo:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'archivo' => $request->file('file') ? $request->file('file')->getClientOriginalName() : 'N/A'
            ]);

            return response()->json([
                'message' => 'Error interno del servidor',
                'error' => $e->getMessage()
            ], 500);
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

        $media = auth()->user()->multimedia()->create([
            'file_path' => $path,
            'type' => str_contains($mimeType, 'video') ? 'video' : 'photo',
            'is_temp' => true,
            'title' => 'Temporal-'.uniqid()
        ]);

        return response()->json([
            'id' => $media->id,
            'path' => $path,
            'url' => Storage::url($path),
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
        $multimedia = auth()->user()->multimedia()->findOrFail($id);

        $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string'
        ]);

        $multimedia->update($request->all());

        return $multimedia;
    }

    // Eliminar archivo (protegido)
    public function destroy($id)
    {
        $multimedia = auth()->user()->multimedia()->findOrFail($id);

        Storage::disk('public')->delete($multimedia->file_path);
        $multimedia->delete();

        return response()->noContent();
    }
}
