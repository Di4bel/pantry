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
    <flux:heading level="1" size="lg" class="mb-2">Recipes</flux:heading>
    <div class="mb-2 flex flex-col sm:flex-row gap-2 sm:gap-20 text-right">
        <div class="flex flex-grow gap-2">
            <flux:input type="search" placeholder="Search" />
            <flux:button variant="subtle" class="" ><flux:icon.magnifying-glass /> </flux:button>
        </div>
        <flux:button variant="primary" href="{{route('recipes.create')}}" >{{ __('Create Recipe') }}</flux:button>
    </div>
    <div class="p-4">
        <table id="recipes" class="border-gray-200 rounded overflow-hidden w-full">
            <thead>
                <tr class="">
                    <th class="p-2 text-left border max-w-xs truncate">Title</th>
                    <th class="p-2 text-left border">Creator</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recipes as $recipe)
                    <tr class="border border-gray-200">
                        <td class="p-2 border"><a href="{{route('recipes.show',$recipe)}}">{{$recipe->title}}</a> </td>
                        <td class="p-2 border"><a href="{{route('users.show',$recipe->creator)}}">{{$recipe->creator->name}}</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>