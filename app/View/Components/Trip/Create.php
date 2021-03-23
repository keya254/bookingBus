<?php

namespace App\View\Components\Trip;

use Illuminate\View\Component;

class Create extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $cars;
    public $drivers;
    public $governorates;
    public function __construct($cars,$drivers,$governorates)
    {
        $this->cars=$cars;
        $this->drivers=$drivers;
        $this->governorates=$governorates;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.trip.create');
    }
}
