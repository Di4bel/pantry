<?php

declare(strict_types=1);

test('create ShoppingList', function (): void {
    $shoppingList = App\Models\ShoppingList::factory()->create();

    expect($shoppingList)->toBeInstanceOf(App\Models\ShoppingList::class);
});

test('create ShoppingList with user_id', function (): void {
    $user = App\Models\User::factory()->create();
    $shoppingList = App\Models\ShoppingList::factory()->create(['user_id' => $user->id]);
    expect($shoppingList->user_id)->toBe($user->id);
});

test('create ShoppingList with ShoppingListItems', function (): void {
    $user = App\Models\User::factory()->create();
    App\Models\ShoppingList::factory()
        ->for($user)
        ->has(App\Models\ShoppingListItem::factory(3)->for($user), 'shoppingListItems')
        ->create();

    expect($user->shoppingLists)->toHaveCount(1)
        ->and($user->shoppingLists()->first()->shoppingListItems)->toHaveCount(3);
});

test('create ShoppingListItems', function (): void {
    $user = App\Models\User::factory()->create();
    $shoppingList = App\Models\ShoppingList::factory()->create(['user_id' => $user->id]);

    App\Models\ShoppingListItem::factory(3)
        ->for($user, 'user')
        ->for($shoppingList, 'shoppingList')
        ->create();

    expect($user->shoppingListItems)->toHaveCount(3);
});
