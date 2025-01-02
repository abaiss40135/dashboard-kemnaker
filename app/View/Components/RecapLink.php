<?php

namespace App\View\Components;

use Illuminate\View\Component;

class RecapLink extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $title,
        public string $icon,
        public string $bg,
        public ?string $attrs = null
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('templates.dashboard.components.recap-link');
    }
}
