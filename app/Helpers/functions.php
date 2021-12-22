<?php

if (!function_exists('getCurrencySign')) {
    function getCurrencySign($price)
    {
        return $price . ' €';
    }
}
