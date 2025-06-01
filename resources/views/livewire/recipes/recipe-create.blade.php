<?php

use function Livewire\Volt\{state,mount};


state([
    'recipe' => [
        'creator_id' => null,
        'ingredients' => [],
        'description' => '',
    ],
]);

mount(function () {
    $this->recipe['creator_id'] = Auth::user()->id;
});
?>

<div class="h-1/4 flex flex-col">
    <div class="flex-grow">
        <x-editor wire:model="recipe.description" class="dark:bg-gray-800 dark:text-white rounded h-full" ></x-editor>
    </div>
</div>
