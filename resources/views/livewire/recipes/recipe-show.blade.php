<?php

use function Livewire\Volt\{state};

state(['recipe' => fn() => $recipe]);
?>

<div>
    {{dump($recipe)}}
</div>
