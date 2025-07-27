<?php

use Livewire\Volt\Component;
use \App\Models\User;
use \App\Models\Recipe;
use \Livewire\WithPagination;
use Livewire\Attributes\Lazy;


new
#[Lazy]
class extends Component {

    public Recipe $recipe;
    public User $creator;
    public bool $creatorLoggedIn;
    public function mount(Recipe $recipe)
    {
        $this->recipe = $recipe;
        $this->creator = $recipe->creator;
        $this->creatorLoggedIn = auth()->user()->id === $recipe->creator->id;
    }
    public function with():array
    {
        return [

        ];
    }

    public function copy()
    {
        $recipe = $this->recipe->replicate()->fill(['creator_id' => auth()->user()->id]);
        $recipe->save();
        $this->redirectRoute('recipes.edit',$recipe);
    }
};
?>

<div class="">
    <div class="">
        <flux:heading size="xl" level="1" class="mb-2">
            {{$recipe->title}}
            @if($creatorLoggedIn)
                <flux:button icon="pencil-square" size="xs" variant="ghost" href="{{route('recipes.edit',$recipe)}}"/>
            @else
                <flux:button icon="document-duplicate" size="xs" variant="ghost" wire:confirm="Do you really wanna copy the Recipe?" wire:click="copy" >copy</flux:button>
            @endif
        </flux:heading>
        <div class="flex items-center gap-2 sm:gap-4">
                <flux:avatar circle size="lg" class="max-sm:size-8" name="{{$creator->name}}" />
                <div class="flex flex-col">
                    <flux:heading>{{$creator->name}}
                        @if($creatorLoggedIn)
                            <flux:badge size="sm" color="blue" class="ml-1 max-sm:hidden">You</flux:badge>
                        @endif
                    </flux:heading>
                    <flux:text class="max-sm:hidden">{{$creator->email}}</flux:text>
                </div>
        </div>
    </div>
    <div class="mt-4 grid grid-cols-2 gap-x-2">
        <div class="rounded p-4 border dark:border-gray-200  sm:col-span-1 col-span-2 ">
            <table class="border-collapse table-auto w-full ">
                <thead class="text-sm">
                <tr>
                    <th class="border-b border-r border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-400 dark:border-gray-400 dark:text-gray-200">Ingredients</th>
                    <th class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-400 dark:border-gray-400 dark:text-gray-200">Amount</th>
                </tr>
                </thead>
                <tbody class="">
                @foreach($recipe->ingredients as $ingredient)
                    <tr>
                        <td class="border border-gray-100 p-4 pl-8 text-gray-800 dark:border-gray-400 dark:text-gray-400">
                            <flux:text>{{$ingredient['name']}}</flux:text>
                        </td>
                        <td class="border border-gray-100 p-4 pl-8 text-gray-800 dark:border-gray-400 dark:text-gray-400">
                            <flux:text>{{$ingredient['amount']}} {{$ingredient['type'] === 'count' ? '*': $ingredient['type']  }}</flux:text>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="sm:col-span-1 col-span-2 p-2">
            Images Soon TM
        </div>

    </div>
    <div class="mt-4">
        <div class="bg-gray-300 rounded-sm p-4 w-full">
            <div class=" prose max-w-none overflow-clip">
                {!! $recipe->description  !!}
            </div>
        </div>
    </div>
</div>
