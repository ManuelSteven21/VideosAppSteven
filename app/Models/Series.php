<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Series extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'user_name',
        'user_photo_url',
        'published_at',
    ];

    /**
     * Campos que deben tratarse como fechas (Carbon)
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'published_at'];

    public function videos(): HasMany
    {
        return $this->hasMany(Video::class);
    }

    /**
     * Devuelve la fecha publicada formateada (ej: "13 de enero de 2025").
     */
    public function getFormattedPublishedAtAttribute(): ?string
    {
        return $this->published_at
            ? Carbon::parse($this->published_at)->isoFormat('D [de] MMMM [de] YYYY')
            : null;
    }

    /**
     * Devuelve la fecha publicada en formato relativo (ej: "hace 3 días").
     */
    public function getFormattedForHumansPublishedAtAttribute(): ?string
    {
        return $this->published_at
            ? Carbon::parse($this->published_at)->diffForHumans()
            : null;
    }

    /**
     * Devuelve el timestamp de la fecha publicada.
     */
    public function getPublishedAtTimestampAttribute(): ?int
    {
        return $this->published_at
            ? Carbon::parse($this->published_at)->timestamp
            : null;
    }

    /**
     * Devuelve la fecha de creación formateada.
     */
    public function getFormattedCreatedAtAttribute(): ?string
    {
        return $this->created_at
            ? Carbon::parse($this->created_at)->format('d/m/Y H:i')
            : null;
    }

    /**
     * Devuelve la fecha de creación en formato relativo.
     */
    public function getFormattedForHumansCreatedAtAttribute(): ?string
    {
        return $this->created_at
            ? Carbon::parse($this->created_at)->diffForHumans()
            : null;
    }

    /**
     * Devuelve el timestamp de la fecha de creación.
     */
    public function getCreatedAtTimestampAttribute(): ?int
    {
        return $this->created_at
            ? Carbon::parse($this->created_at)->timestamp
            : null;
    }
}
