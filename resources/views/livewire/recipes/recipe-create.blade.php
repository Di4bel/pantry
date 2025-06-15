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
    'newIngredientType' => '',
    'ingredientAmountType' => [
        'count',
        'kg',
        'ml',
        'l',
        'g',
        'tbsp',
        'tsp',
    ]
]);

mount(function () {
    $this->recipe['creator_id'] = Auth::user()->id;
});

$addIngredient = function (){
    $validated = $this->validate([
        'newIngredientName' => 'string|required|max:255',
        'newIngredientAmount' => 'numeric|required',
        'newIngredientType' => [
            'string',
            'required',
            \Illuminate\Validation\Rule::in($this->ingredientAmountType),
        ]
    ]);

    $this->recipe['ingredients'][] = [
        'name' => $validated['newIngredientName'],
        'amount' => $validated['newIngredientAmount'],
        'type' => $validated['newIngredientType']
    ];
    $this->reset('newIngredientName','newIngredientAmount');
    $this->newIngredientType = '';
};

$removeIngredient =  function ($key) {
    unset($this->recipe['ingredients'][$key]);
};
?>
<div class="h-1/4 flex flex-col">
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
                <flux:field class="w-full">
                    <flux:input wire:model="newIngredientName" type="text" placeholder="Ingredient" />
                    <flux:error name="newIngredientName" />
                </flux:field>
                <flux:field class="w-full">
                    <flux:input wire:model="newIngredientAmount" type="number" placeholder="Quantity" />
                    <flux:error name="newIngredientAmount" />
                </flux:field>
                <flux:field class="w-full">
                    <flux:select wire:model="newIngredientType" placeholder="Type...">
                        <flux:select.option >count</flux:select.option>
                        <flux:select.option >kg</flux:select.option>
                        <flux:select.option >ml</flux:select.option>
                        <flux:select.option >l</flux:select.option>
                        <flux:select.option >g</flux:select.option>
                        <flux:select.option >tbsp</flux:select.option>
                        <flux:select.option >tsp</flux:select.option>
                    </flux:select>
                    <flux:error name="newIngredientType" />
                </flux:field>
                 <flux:button.group>
                    <flux:button wire:click="addIngredient" icon="plus"/>
                 </flux:button.group>
            </flux:input.group>
            <div class="">
                @foreach($recipe['ingredients'] as $key => $ingredient)

                        <flux:input.group>
                            <flux:input wire:model="recipe.ingredients.{{$key}}.name" type="text" placeholder="Ingredient" />
                            <flux:input wire:model="recipe.ingredients.{{$key}}.amount" type="number" placeholder="Quantity" />
                            <flux:select wire:model="recipe.ingredients.{{$key}}.type" placeholder="Type">
                                <flux:select.option value="count">count</flux:select.option>
                                <flux:select.option value="kg">kg</flux:select.option>
                                <flux:select.option value="ml">ml</flux:select.option>
                                <flux:select.option value="l">l</flux:select.option>
                                <flux:select.option value="g">g</flux:select.option>
                                <flux:select.option value="tbsp">tbsp</flux:select.option>
                                <flux:select.option value="tsp">tsp</flux:select.option>
                            </flux:select>
                            <flux:button.group>
                                <flux:button  wire:click="duplicateIngredient({{$key}})" icon="clipboard-document"  />
                                <flux:button variant="danger" wire:click="removeIngredient({{$key}})" icon="minus"  />
                            </flux:button.group>
                        </flux:input.group>

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
