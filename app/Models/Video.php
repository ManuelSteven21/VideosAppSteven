<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Video extends Model
{
    use HasFactory;

    // Campos que pueden ser asignados de forma masiva
    protected $fillable = [
        'title',          // Título del video
        'description',    // Descripción del video
        'url',            // URL del video
        'previous',
        'next',
        'series_id', // Asegúrate de incluir este campo
        'published_at',   // Fecha de publicación
    ];

    /**
     * Indica que el campo 'published_at' debe ser tratado como una fecha.
     *
     * @var array<string>
     */
    protected $dates = ['published_at'];

    /**
     * Devuelve la fecha publicada formateada (por ejemplo, "13 de enero de 2025").
     *
     * @return string|null
     */
    public function getFormattedPublishedAtAttribute(): ?string
    {
        if ($this->published_at) {
            return Carbon::parse($this->published_at)->isoFormat('D [de] MMMM [de] YYYY');
        }
        return null;
    }

    /**
     * Devuelve la fecha publicada en un formato legible (por ejemplo, "hace 2 horas").
     *
     * @return string|null
     */
    public function getFormattedForHumansPublishedAtAttribute(): ?string
    {
        if ($this->published_at) {
            return Carbon::parse($this->published_at)->diffForHumans();
        }
        return null;
    }

    /**
     * Devuelve el Unix timestamp de la fecha publicada.
     *
     * @return int|null
     */
    public function getPublishedAtTimestampAttribute(): ?int
    {
        if ($this->published_at) {
            return Carbon::parse($this->published_at)->timestamp;
        }
        return null;
    }
}
