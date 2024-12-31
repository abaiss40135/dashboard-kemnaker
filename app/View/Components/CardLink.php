<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CardLink extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $title,
        public string $desc,
        public string $imgSrc,
        public ?string $btnText = 'Lihat Detail',
        public ?string $action = null,
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('templates.dashboard.components.card-link');
    }
}
