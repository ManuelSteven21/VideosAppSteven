<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


/**
 * App\Models\Video
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $url
 * @property string|null $previous
 * @property string|null $next
 * @property int $series_id
 * @property \Carbon\Carbon|null $published_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 */

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
        'user_id',
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

    public function getPrevious()
    {
        return Video::where('id', '<', $this->id)->orderBy('id', 'desc')->first();
    }

    public function getNext()
    {
        return Video::where('id', '>', $this->id)->orderBy('id', 'asc')->first();
    }

    public function getUrlIdAttribute()
    {
        // Suponiendo que la URL del iframe es algo como 'https://www.youtube.com/embed/VIDEO_ID'
        return preg_match('/embed\/([^\?&]+)/', $this->attributes['url'], $matches) ? $matches[1] : null;
    }

    /**
     * Relació: Un vídeo pertany a un usuari.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
