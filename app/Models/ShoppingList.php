<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\ShoppingListFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class ShoppingList extends Model
{
    /** @use HasFactory<ShoppingListFactory> */
    use HasFactory;

    /*
     * the attributes that are mass assignable
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'description',
        'user_id',
        'closed_at',
    ];

    /*
     *  @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /*
     *  @return HasMany<ShoppingListItem, $this>
     */
    public function shoppingListItems(): HasMany
    {
        return $this->hasMany(ShoppingListItem::class);
    }

    /*
     *  returns the total price of the shopping list
     * @return float
     */
    public function totalPrice(): float
    {
        return $this->shoppingListItems->sum('price');
    }

    protected function casts(): array
    {
        return [
            'closed_at' => 'datetime',
        ];
    }
}
