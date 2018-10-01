<?php

namespace App\Services\Maps\Contracts;

interface Geocoder
{
    public function locate($address);
}
