<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class ShoppingList extends Model
{
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
     *  @return HasMany<ShoppingListItem, $this>
     */
    public function items(): HasMany
    {
        return $this->hasMany(ShoppingListItem::class, 'shopping_list_id');
    }

    protected function casts(): array
    {
        return [
            'closed_at' => 'datetime',
        ];
    }
}
