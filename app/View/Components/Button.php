<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component
{
    public $href;
    public $icon;

    public function __construct($href = '#', $icon = null)
    {
        $this->href = $href;
        $this->icon = $icon;
    }

    public function render()
    {
        return view('components.button');
    }
}
