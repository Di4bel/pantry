<?php

declare(strict_types=1);

arch('app')
    ->expect('App')
    ->toUseStrictTypes()
    ->not->toUse(['die', 'dd', 'dump']);

arch()
    ->expect('App\Models')
    ->toBeClasses()
    ->toExtend('Illuminate\Database\Eloquent\Model');

arch()
    ->expect('App\Http')
    ->toOnlyBeUsedIn('App\Http');

arch()
    ->expect('App\Actions')
    ->toBeClasses()
    ->toHaveMethod('handle');

arch()->preset()->php();
arch()->preset()->security();

arch()->preset()->laravel();
