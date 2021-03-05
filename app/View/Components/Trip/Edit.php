<?php

namespace App\View\Components\Trip;

use Illuminate\View\Component;

class Edit extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $cars;
    public $drivers;
    public function __construct($cars,$drivers)
    {
        $this->cars=$cars;
        $this->drivers=$drivers;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.trip.edit');
    }
}
