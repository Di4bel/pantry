<?php

use function Livewire\Volt\{state,mount};


state([
    'recipe' => [
        'title' => '',
        'creator_id' => null,
        'ingredients' => [],
        'description' => '',
    ],
    'newIngredientName',
    'newIngredientAmount',
    'newIngredientType',
]);

mount(function () {
    $this->recipe['creator_id'] = Auth::user()->id;
});

$addIngredient = function (){
    $validated = $this->validate([
        'newIngredientName' => 'string|required',
        'newIngredientAmount' => 'numeric|required',
        'newIngredientType' => 'string|required'
    ]);

    $this->recipe['ingredients'][] = [
        'name' => $validated['newIngredientName'],
        'amount' => $validated['newIngredientAmount'],
        'type' => $validated['newIngredientType']
    ];
    $this->reset('newIngredientName','newIngredientAmount','newIngredientType');
};

$removeIngredient =  function ($key) {
    unset($this->recipe['ingredients'][$key]);
};
?>
<div class="h-1/4 flex flex-col">
    @dump($recipe['ingredients'])
    <div class="p-2">
        <flux:field>
            <flux:label>Title:</flux:label>
            <flux:input type="text" wire:model.live="recipe.title" />
            <flux:error name="recipe.title" />
        </flux:field>
    </div>
    <div class="p-2">
        <flux:fieldset class="gap-y-2">
            <flux:legend>Ingredients</flux:legend>
            <flux:input.group>
                <flux:input wire:model.live="newIngredientName" type="text" placeholder="Ingredient" />
                <flux:input wire:model.live="newIngredientAmount" type="number" placeholder="Quantity" />
                <flux:select wire:model.live="newIngredientType" placeholder="Type">
                    <flux:select.option value="count">count</flux:select.option>
                    <flux:select.option value="kg">kg</flux:select.option>
                    <flux:select.option value="ml">ml</flux:select.option>
                    <flux:select.option value="l">l</flux:select.option>
                    <flux:select.option value="g">g</flux:select.option>
                    <flux:select.option value="tbsp">tbsp</flux:select.option>
                    <flux:select.option value="tsp">tsp</flux:select.option>
                </flux:select>
                <flux:button wire:click="addIngredient" icon="plus" />
            </flux:input.group>
            <div class="space-y-3">
                @foreach($recipe['ingredients'] as $key => $ingredient)
                    @dump($key,$ingredient)
                    <div class="">
                        <flux:input.group>
                            <flux:input wire:model.live="recipe.ingredients.{{$key}}.name" type="text" placeholder="Ingredient" />
                            <flux:input wire:model.live="recipe.ingredients.{{$key}}.amount" type="number" placeholder="Quantity" />
                            <flux:select wire:model.live="recipe.ingredients.{{$key}}.type" placeholder="Type">
                                <flux:select.option value="count">count</flux:select.option>
                                <flux:select.option value="kg">kg</flux:select.option>
                                <flux:select.option value="ml">ml</flux:select.option>
                                <flux:select.option value="l">l</flux:select.option>
                                <flux:select.option value="g">g</flux:select.option>
                                <flux:select.option value="tbsp">tbsp</flux:select.option>
                                <flux:select.option value="tsp">tsp</flux:select.option>
                            </flux:select>
                            <flux:button wire:click="removeIngredient({{$key}})" icon="minus" />
                        </flux:input.group>
                    </div>
                @endforeach
            </div>
        </flux:fieldset>
    </div>
    <div class="flex-grow p-2">
        <flux:field>
            <flux:label>Description:</flux:label>
            <x-editor wire:model="recipe.description" class="dark:bg-gray-800 dark:text-white rounded h-full" ></x-editor>
            <flux:error name="recipe.description" />
        </flux:field>
    </div>
</div>
