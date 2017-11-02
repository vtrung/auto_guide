<?php
/**
 * Created by PhpStorm.
 * User: Ving
 * Date: 10/28/17
 * Time: 4:26 PM
 */

namespace AppBundle\Utility;

use AppBundle\Entity\Car;

class CarUtility{

    public function Compare(Car $car1, Car $car2){

        $mpg = 0;

        $mpg = $car1->getMpg() - $car2->getMpg();

        return $mpg;

    }


}