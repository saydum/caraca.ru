<?php

namespace App\View\Components;

use Illuminate\View\Component;

class GuestLayout extends Component
{
    /**
     * Получить view/шаблон компонента.
     */
    public function render()
    {
        return view('layouts.guest');
    }
}
