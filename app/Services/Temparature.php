<?php

namespace App\Services;

class Temparature
{
    protected $temparature;

    public function __construct($temparature, $region)
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

    public function toKelvin()
    {
        return $this->temparature + 273.15;
    }

    public function toCelsius()
    {
        return $this->temparature;
    }

    public function toFahrenheit()
    {
        return round(($this->temparature * 9 / 5) + 32, 2);
    }
}
