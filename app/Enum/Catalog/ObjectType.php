<?php

namespace App\Enum\Catalog;

enum ObjectType: string
{
    case Apartment = 'apartments';
    case Room = 'rooms';
    case House = 'houses_and_villas';
    case Bed = 'beds';
    case Ground = 'ground';
    case Garage = 'garages';
    case Commerce = 'commercial';
}
