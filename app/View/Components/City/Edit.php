<?php

namespace App\View\Components\City;

use Illuminate\View\Component;

class Edit extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $governorates;

    public function __construct($governorates)
    {
       $this->governorates=$governorates;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.city.edit');
    }
}
