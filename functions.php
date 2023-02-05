<?php
function format_price($price): string
{
    if ($price < 1000) {
        return $price . ' ₽';
    } else {
        return number_format(ceil($price), $decimals = 0, $decimal_separator = ".", $thousands_separator = " ") . ' ₽';
    }
}