<?php

namespace App\View\Components\Bujp;

use Illuminate\View\Component;

class DataPelakuUsaha extends Component
{
    public $nib;

    public $collapse;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($bujp, $collapse = true)
    {
        $this->nib = $bujp->nib;
        $this->collapse = $collapse ? 'collapsed-card' : '';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.bujp.data-pelaku-usaha');
    }
}
