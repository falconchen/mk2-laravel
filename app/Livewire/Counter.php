<?php



namespace App\Livewire;

use Livewire\Component;

class Counter extends Component
{
    public $count = 1;
    public $timeNow ;


    public function __construct()
    {
        $this->refresh();
    }
    public function refresh()
    {
        $this->timeNow = now();
    }

    public function increment()
    {
        $this->count++;
    }

    public function decrement()
    {
        $this->count--;
    }

    public function render()
    {
        return view('livewire.counter');
    }

}
