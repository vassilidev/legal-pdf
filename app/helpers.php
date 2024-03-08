<?php

use App\Enums\Currency;
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

// app/helpers.php

if (!function_exists('formatCurrency')) {
    function formatCurrency(int $price, $currency): string
    {
        $symbol = $currency->getSymbol();

        $formattedAmount = number_format($price / 100, 2);

        if ($currency === Currency::EUR) {
            return "{$formattedAmount}{$symbol}";
        }

        return "{$symbol}{$formattedAmount}";
    }
}
