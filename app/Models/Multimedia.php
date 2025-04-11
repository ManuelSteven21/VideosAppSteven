<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\BelongsTo;



class Multimedia extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'file_path',
        'type'
    ];

    protected $appends = ['file_url'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getFileUrlAttribute()
    {
        return Storage::disk('public')->url($this->file_path);
    }
}
