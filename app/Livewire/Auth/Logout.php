<?php

namespace App\Livewire\Auth;

use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Logout extends Component
{
    public function logout()
    {
        Auth::logout();

        // 重定向到首页或登录页
        return redirect()->route('login');
    }

    public function render()
    {
        return <<<'HTML'

        <a wire:click="logout"  class="inline-block text-sm px-4 py-2 leading-none border rounded text-white border-white hover:border-blue-800 hover:text-white">
                    Logout
                </a>
        HTML;
    }
}
