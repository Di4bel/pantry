<?php

use Livewire\Component;
use \App\Models\User;
use \App\Models\Recipe;
use \Livewire\WithPagination;
use Livewire\Attributes\Lazy;


new
#[Lazy]
class extends Component {
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
    <flux:separator class="my-4"/>

    @if(!blank($recipes))
        <div class="p-1 border rounded-sm">
            <table id="recipes" class="table-auto border-collapse w-full">
                <thead>
                <tr class="">
                    <th class="p-2 text-left border-r border-b max-w-xs truncate">Title</th>
                    <th class="p-2 text-left border-b">Creator</th>
                </tr>
                </thead>
                <tbody>
                @foreach($recipes as $recipe)
                    <tr class=" border border-gray-200">
                        <td class="p-2 border-r "><a class="hover:text-pink-300" href="{{route('recipes.show',$recipe)}}">{{$recipe->title}}</a> </td>
                        <td class="p-2 "><flux:avatar as="button" href="{{route('users.show',$recipe->creator)}}" name="{{$recipe->creator->name}}" color="auto" color:seed="{{$recipe->creator->id}}" /></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @else
        <flux:heading size="xl" level="3" class="text-center">0 Recipes found!</flux:heading>
        <flux:spacer class="m-2" />
        <flux:heading size="xl" level="3" class="text-center"><flux:button  href="{{route('recipes.create')}}">Create some awesome new Recipes!</flux:button></flux:heading>
    @endif
</div>