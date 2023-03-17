<?php

namespace App\Enums;

enum WeatherEnum: string
{
    case SUNNY = 'sunny';
    case STORMY = 'stormy';
    case RAINY = 'rainy';
    case WINDY = 'windy';
    case CLOUDY = 'cloudy';
}
