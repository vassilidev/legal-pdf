<?php

use Illuminate\Support\Collection;

function recursiveCollect($array): Collection
{
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $value = recursiveCollect($value);

            $array[$key] = $value;
        }
    }

    return collect($array);
}