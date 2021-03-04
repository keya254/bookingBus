<?php

namespace App\View\Components\Car;

use Illuminate\View\Component;

class Create extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $typecars;
    public function __construct($typecars)
    {
        $this->typecars=$typecars;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.car.create');
    }
}
