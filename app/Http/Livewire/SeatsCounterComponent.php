<?php

namespace App\Http\Livewire;

use Livewire\Component;

class SeatsCounterComponent extends Component
{
    public $count = 1;

    public function increment()
    {
        if ($this->count >= 18) {
            $this->count;
        } else {
            $this->count++;
        }
    }

    public function decrement()
    {
        if ($this->count <= 1) {
            $this->count;
        } else {
            $this->count--;
        }
    }

    public function render()
    {
        return view('livewire.seats-counter-component');
    }
}
