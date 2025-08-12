<?php

use App\Models\Recipe;
use function Livewire\Volt\{rules, state, mount, usesFileUploads};

usesFileUploads();


state(['recipe'])->locked();
state([
    'title' => '',
    'ingredients' => collect(),
    'description' => '',
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
    ],
    'photos',
    'newPhotos' => [],
    'photosRemoveID' => [],
]);


mount(function (Recipe $recipe) {
    $this->recipe = $recipe;
    $this->title = $recipe->title;
    $this->ingredients = collect($recipe->ingredients);
    $this->description = $recipe->description;
    $this->photos = $recipe->getMedia();
});


rules([
    'title' => 'string|required',
    'ingredients' => 'array|required',
    'ingredients.*.name' => 'string|required|max:255',
    'ingredients.*.amount' => 'numeric|required',
    'ingredients.*.type' => [
        'string',
        'required',
        \Illuminate\Validation\Rule::in([
                'count',
                'kg',
                'ml',
                'l',
                'g',
                'tbsp',
                'tsp',]
        ),
    ],
    'ingredients.*.order' => 'required|numeric',
    'description' => 'string|required|regex:/^.+$/'
]);

$addIngredient = function () {
    $validated = $this->validate([
        'newIngredientName' => 'string|required|max:255',
        'newIngredientAmount' => 'numeric|required',
        'newIngredientType' => [
            'string',
            'required',
            \Illuminate\Validation\Rule::in($this->ingredientAmountType),
        ],
    ]);

    $this->ingredients[] = [
        'name' => $validated['newIngredientName'],
        'amount' => $validated['newIngredientAmount'],
        'type' => $validated['newIngredientType'],
        'order' => count($this->ingredients),
    ];
    $this->reset('newIngredientName', 'newIngredientAmount');
    $this->newIngredientType = '';
};

$removeIngredient = function ($key) {
    unset($this->ingredients[$key]);
    $this->ingredients = $this->ingredients->values();
};

$saveRecipe = function () {
    $action = new \App\Actions\UpdateRecipeAction();
    $validated = $this->validate();
    $recipe = $action->handle($this->recipe, $validated);
};

$changeIngredientsOrder = function (int $itemOrderOldKey, int $newKey) {
    if (isset($this->ingredients[$itemOrderOldKey]) && isset($this->ingredients[$newKey])) {
        // Convert to array, reorder, and convert back to collection
        $ingredients = $this->ingredients->toArray();

        // Extract the item to move
        $movedItem = $ingredients[$itemOrderOldKey];

        // Remove the item from its original position
        unset($ingredients[$itemOrderOldKey]);

        // Reindex the array to ensure sequential keys
        $ingredients = array_values($ingredients);

        // Insert the item at the new position
        array_splice($ingredients, $newKey, 0, [$movedItem]);

        // Convert back to collection and update order values sequentially
        $this->ingredients = collect($ingredients)->map(function ($item, $key) {
            $item['order'] = $key;
            return $item;
        })->values();
    }
};

$removeRecipe = function () {
    $this->recipe->delete();
    $this->dispatch('DeleteRecipe');
    $this->redirectRoute('recipes.index');
};

$removePhoto = function (int $photoKey): void {
    $this->photosRemoveID[] = $this->photos[$photoKey]->id;
    unset($this->photos[$photoKey]);
    dump($this->photosRemoveID);
};

?>

<div class="h-1/4 flex flex-col">
    <div class="p-2 sm:justify-end flex sm:flex-row sm:gap-4 flex-col gap-2 mb-8">
        <flux:button variant="danger" icon:trailing="trash" wire:confirm="Do you wanna delete this Recipe?"
                     wire:click="removeRecipe()">Delete Recipe
        </flux:button>
        <flux:button variant="primary" icon:trailing="plus" wire:click="saveRecipe()">Save Recipe</flux:button>
    </div>
    <div class="p-2">
        <flux:field>
            <flux:label>Title:</flux:label>
            <flux:input type="text" wire:model.live="title"/>
            <flux:error name="title"/>
        </flux:field>
    </div>
    <div class="p-2">
        <flux:input type="file" wire:model="newUploadPhotos" label="Photos:" multiple/>
        <div class="border border-dashed w-full h-12 my-4">

        </div>
        <div class="m-2" wire:loading wire:target="photo">Uploading...</div>
        <div class="grid sm:grid-cols-4 grid-cols-1 gap-2 m-2">
            @foreach($photos as $key => $photo)
                <div wire:key="photo-{{$key}}" class="col-span-1 relative border p-1 rounded-sm shadow-sm ">
                    <flux:button.group class="absolute top-0 right-0">

                        <flux:button wire:click="removePhoto({{$key}})" variant="ghost">
                            <flux:icon.minus-circle variant="solid" color="red"/>
                        </flux:button>
                    </flux:button.group>
                    <img class="object-contain mb-2" src="{{$photo->getUrl()}}" wire:click="remove" alt=""/>
                    <flux:separator/>
                    <flux:input type="text" label="Title"></flux:input>
                </div>
            @endforeach
            @foreach($newPhotos as $key => $photo)
                <div wire:key="newPhoto-{{$key}}" class="col-span-1 relative border p-1 rounded-sm shadow-sm ">
                    <flux:button.group class="absolute top-0 right-0">

                        <flux:button wire:click="removePhoto({{$key}})" variant="ghost">
                            <flux:icon.minus-circle variant="solid" color="red"/>
                        </flux:button>
                    </flux:button.group>
                    <img class="object-contain mb-2" src="{{$photo->temporaryUrl()}}" wire:click="remove" alt=""/>
                    <flux:separator/>
                    <flux:input type="text" label="Title"></flux:input>
                </div>
            @endforeach
        </div>
    </div>
    <div class="p-2">
        <flux:fieldset class="gap-y-2">
            <flux:legend>Ingredients</flux:legend>
            <flux:input.group>
                <flux:field class="w-full">
                    <flux:input wire:model="newIngredientName" type="text" placeholder="Ingredient"/>
                    <flux:error name="newIngredientName"/>
                </flux:field>
                <flux:field class="w-full">
                    <flux:input wire:model="newIngredientAmount" type="number" placeholder="Quantity"/>
                    <flux:error name="newIngredientAmount"/>
                </flux:field>
                <flux:field class="w-full">
                    <flux:select wire:model="newIngredientType" placeholder="Type...">
                        <flux:select.option>count</flux:select.option>
                        <flux:select.option>kg</flux:select.option>
                        <flux:select.option>ml</flux:select.option>
                        <flux:select.option>l</flux:select.option>
                        <flux:select.option>g</flux:select.option>
                        <flux:select.option>tbsp</flux:select.option>
                        <flux:select.option>tsp</flux:select.option>
                    </flux:select>
                    <flux:error name="newIngredientType"/>
                </flux:field>
                <flux:button.group>
                    <flux:button wire:click="addIngredient" icon="plus"/>
                </flux:button.group>
            </flux:input.group>
            <flux:error name="ingredient"/>
            <div class="mt-2" id="ingredientsList">
                @foreach($ingredients as $key => $ingredient)

                    <flux:input.group wire:key="{{$key}}">
                        <flux:input wire:model.live="ingredients.{{$key}}.name" type="text" placeholder="Ingredient"/>
                        <flux:input wire:model.live="ingredients.{{$key}}.amount" type="number"
                                    placeholder="Quantity"/>
                        <flux:select wire:model.live="ingredients.{{$key}}.type" placeholder="Type">
                            <flux:select.option value="count">count</flux:select.option>
                            <flux:select.option value="kg">kg</flux:select.option>
                            <flux:select.option value="ml">ml</flux:select.option>
                            <flux:select.option value="l">l</flux:select.option>
                            <flux:select.option value="g">g</flux:select.option>
                            <flux:select.option value="tbsp">tbsp</flux:select.option>
                            <flux:select.option value="tsp">tsp</flux:select.option>
                        </flux:select>
                        <flux:button.group>
                            <flux:button wire:click="duplicateIngredient({{$key}})" icon="clipboard-document"/>
                            <flux:button variant="danger" wire:click="removeIngredient({{$key}})" icon="minus"/>
                        </flux:button.group>
                    </flux:input.group>

                @endforeach
            </div>
        </flux:fieldset>
    </div>
    <div class="flex-grow p-2 ">
        <div>
            <flux:field>
                <flux:label>Description:</flux:label>
                <x-editor wire:model="description"
                          class="dark:bg-gray-800 dark:text-white rounded h-full"></x-editor>

            </flux:field>
        </div>
        <flux:error class="mt-16" name="description"/>
    </div>

    @script
    <script>
        Sortable.create(document.getElementById('ingredientsList'),
            {
                onSort: function (event) {
                    $wire.changeIngredientsOrder(event.oldIndex, event.newIndex);
                }
            });
    </script>
    @endscript
</div>
