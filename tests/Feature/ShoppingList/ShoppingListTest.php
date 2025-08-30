<?php

declare(strict_types=1);

test('shoppingListItems sum correctly currency', function (): void {
    $user = App\Models\User::factory()->create();
    $shoppingList = App\Models\ShoppingList::factory()->create(['user_id' => $user->id]);
    $shoppingListItems = App\Models\ShoppingListItem::factory(3)->for($user)->for($shoppingList)->create();
    $sum = Number::currency($shoppingListItems->sum('price'));
    expect(Number::currency($shoppingList->totalPrice()))->toBe($sum);
});

test('shopping list-Items prices are stored via factor 100', function (): void {
    $user = App\Models\User::factory()->create();
    $shoppingList = App\Models\ShoppingList::factory()->create(['user_id' => $user->id]);
    $shoppingListItems = App\Models\ShoppingListItem::factory(3)->for($user)->for($shoppingList)->create();
    $sum = $shoppingList->shoppingListItems()->sum('price');
    $intVal = (int) (round($shoppingList->totalPrice() * 100));
    expect($intVal)->toBe($sum);
});
