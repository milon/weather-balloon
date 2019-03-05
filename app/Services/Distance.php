<?php

namespace App\Services;

class Distance
{
    protected $distance;

    public function __construct($distance, $region)
    {
        $this->distance = $this->convertToKm($distance, $region);
    }

    protected function convertToKm($distance, $region)
    {
        if($region === 'US') {
            return $distance * 1.61;
        }

        if($region === 'FR') {
            return $distance / 1000;
        }

        return $distance;
    }

    public function toKm()
    {
        return $this->distance;
    }

    public function toMeter()
    {
        return $this->distance * 1000;
    }

    public function toMiles()
    {
        return $this->distance / 0.62;
    }
}
