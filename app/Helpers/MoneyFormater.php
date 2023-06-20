<?php

namespace App\Helpers;

readonly class MoneyFormater
{
    public static function getMoneyValue($value): string
    {
        $amount = explode(".", $value / 100);
        $whole = $amount[0];

        $decimal = $amount[1] ?? "00";

        if (strlen($whole) > 3) {
            $temp = "";
            $j = 0;
            for ($i = strlen($whole) - 1; $i >= 0; $i--) {
                $temp = $whole[$i] . $temp;
                $j++;
                if ($j % 3 === 0 && $i !== 0) {
                    $temp = "." . $temp;
                }
            }
            $whole = $temp;
        }
        return "$whole,$decimal";
    }
}
