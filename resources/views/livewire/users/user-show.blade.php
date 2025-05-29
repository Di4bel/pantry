<?php

use App\Models\User;
use Livewire\Volt\Component;

new class extends Component {
    public User $user;
    public function mount(User $user): void
    {

    }
}; ?>

<div>
    {{dump($user)}}
</div>
