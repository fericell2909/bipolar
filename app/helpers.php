<?php

if (!function_exists('calculate_percentage')) {
    function calculate_percentage($total, $percentage) {
        $discount = $total * ($percentage / 100);

        return $discount;
    }
}