<?php

use Livewire\Volt\Component;
use \App\Models\User;
use \App\Models\Recipe;
use \Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public function with():array
    {
        return [
            'recipes' => Recipe::paginate(),
        ];
    }
}; ?>

<div>
    <table id="recipes">
        <thead>
            <tr>
                <p>Title</p>
            </tr>
        </thead>
        <tbody>
            @foreach($recipes as $recipe)
                <tr>
                    <p>{{$recipe->title}}</p>
                </tr>
            @endforeach

        </tbody>
    </table>
</div>
