<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Multimedia extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'file_path',
        'type'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accesor para la URL pública del archivo
    public function getFileUrlAttribute()
    {
        return Storage::disk('public')->url($this->file_path);
    }

    // Accesor para determinar si es imagen
    public function getIsImageAttribute()
    {
        return strpos($this->type, 'photo') !== false;
    }

    // Accesor para determinar si es video
    public function getIsVideoAttribute()
    {
        return strpos($this->type, 'video') !== false;
    }

    protected $appends = ['file_url', 'thumbnail_url'];
}
