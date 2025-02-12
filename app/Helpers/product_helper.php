<?php

if (!function_exists('format_price')) {
    function format_price($price)
    {
        return "Rp" . number_format($price, 0, ',', '.');
    }
}

if (!function_exists('calculate_discount')) {
    function calculate_discount($price, $percentage)
    {
        return $price - ($price * ($percentage / 100));
    }
}
