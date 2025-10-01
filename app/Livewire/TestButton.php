<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Log;

class TestButton extends Component
{
    public $message = 'Click the button to test Livewire';

    public function testClick()
    {
        $this->message = 'Button worked! Livewire is functioning properly.';
        Log::info('TestButton clicked successfully');
    }

    public function render()
    {
        return view('livewire.test-button');
    }
}
