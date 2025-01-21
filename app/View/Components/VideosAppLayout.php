<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class VideosAppLayout extends Component
{
    /**
     * El títol de la pàgina.
     */
    public $title;

    public function __construct($title = null)
    {
        $this->title = $title;
    }

    /**
     * Retorna la vista del layout.
     */
    public function render(): View|Closure|string
    {
        return view('components.videos-app-layout');
    }
}
