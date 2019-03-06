<?php

namespace App\Services;

class Temparature
{
    protected $temparature;

    public function __construct($temparature, $region = 'AU')
    {
        $this->temparature = $this->convertToCelsius($temparature, $region);
    }

    protected function convertToCelsius($temparature, $region)
    {
        if($region === 'AU') {
            return $temparature;
        }

        if($region === 'US') {
            return round(($temparature - 32) * 5 / 9, 2);
        }

        return $temparature - 273.15;
    }

    public function toK()
    {
        return round($this->temparature + 273.15, 2);
    }

    public function toC()
    {
        return round($this->temparature, 2);
    }

    public function toF()
    {
        return round(($this->temparature * 9 / 5) + 32, 2);
    }

    public function toRegion($region)
    {
        if($region === 'AU') {
            return $this->toC();
        }

        if($region === 'US') {
            return $this->toF();
        }

        return $this->toK();
    }
}
