<?php
/**
 * Created by PhpStorm.
 * @author d.shokel@gmail.com
 */

namespace EasiestWay\VehicleBundle\Type;


class Manager
{
    public function getList()
    {
        return array(
            0 => 'Unknown',
            1 => 'Cupe',
            2 => 'Cabriolet',
            3 => 'Hatchback',
            4 => 'Sedan',
            5 => 'Universal',
            6 => 'Miniven',
            7 => 'Crossover',
            8 => 'SUV',
            9 => 'Pickup'
        );
    }
} 