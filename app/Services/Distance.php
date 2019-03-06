<?php

namespace App\Services;

class Distance
{
    protected $distance;

    public function __construct($distance, $region = 'AU')
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
        return round($this->distance, 2);
    }

    public function toM()
    {
        return round($this->distance * 1000, 2);
    }

    public function toMiles()
    {
        return round($this->distance / 0.62, 2);
    }

    public function toRegion($region)
    {
        if($region === 'US') {
            return $this->toMiles();
        }

        if($region === 'FR') {
            return $this->toM();
        }

        return $this->toKm();
    }
}
