<?php

namespace App\Helpers;

class FormatHelper
{
    public static function formatPrice($price)
    {
        return number_format($price, 0, ',', '.') . ' VNĐ';
    }

    public static function formatDate($date)
    {
        return date('d/m/Y', strtotime($date));
    }

    public static function formatDateTime($date)
    {
        return date('d/m/Y H:i', strtotime($date));
    }

    public static function formatArea($area)
    {
        return $area . 'm²';
    }

    public static function formatPhoneNumber($phone)
    {
        return preg_replace('/(\d{4})(\d{3})(\d{3})/', '$1 $2 $3', $phone);
    }

    public static function formatAddress($address, $district, $city)
    {
        return $address . ', ' . $district . ', ' . $city;
    }
} 