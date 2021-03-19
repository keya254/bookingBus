<?php

namespace App\View\Components\citiescar;

use Illuminate\View\Component;

class create extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $cars;
    public $governorates;
    public function __construct($cars,$governorates)
    {
       $this->cars=$cars;
       $this->governorates=$governorates;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.citiescar.create');
    }
}
