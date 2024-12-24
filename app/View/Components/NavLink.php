<?php

namespace App\View\Components;

use Illuminate\View\Component;

class NavLink extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $route,
        public string $title
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('templates.dashboard.components.nav-link');
    }
}
