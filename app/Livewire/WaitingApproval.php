<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class WaitingApproval extends Component
{
    public $approved = false;

    // Livewire のイベントを受け取る
    protected $listeners = ['checkApproval' => 'checkApproval'];

    public function mount()
    {
        $this->checkApproval();
    }

    public function checkApproval()
    {
        $user = Auth::user()->fresh();
        $this->approved = $user->is_approved;

        if ($this->approved) {
            // 承認済みならスレッド一覧にリダイレクト
            return redirect()->route('threads.index');
        }
    }

    public function render()
    {
        return view('livewire.waiting-approval');
    }
}
