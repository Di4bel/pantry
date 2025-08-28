<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\ShoppingListItemFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class ShoppingListItem extends Model
{
    /** @use HasFactory<ShoppingListItemFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shopping_list_id',
        'name',
        'amount',
        'amount_type',
        'price',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function shoppingList(): BelongsTo
    {
        return $this->belongsTo(ShoppingList::class);
    }

    /*
     *  transforms the price to store in integer and returns float
     *
     *  @return Attribute<int,int>
     */
    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn (int $value): int => $value / 100,
            set: fn (float $value): int => (int) round($value * 100),
        );
    }
}
