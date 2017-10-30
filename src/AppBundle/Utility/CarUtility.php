<?php
/**
 * Created by PhpStorm.
 * User: Ving
 * Date: 10/28/17
 * Time: 4:26 PM
 */

namespace AppBundle\Utility;

use AppBundle\Entity\Car;

class CarUtility
{
    public function Compare(Car $car1, Car $car2){

        $mpg = 0;

        $mpg = $car1->getMpg() - $car2->getMpg();

        return $mpg;

    }


    public function GetAllYears($em){
        $query = $em->createQuery(
            'SELECT DISTINCT c.year FROM AppBundle:Car c'
        );
        return $query->getResult();
    }

    public function GetMake($em, $year){
        $query = $em->createQuery(
            'SELECT DISTINCT c.make 
              FROM AppBundle:Car c 
              WHERE c.year=:year'
        )->setParameter('year', $year);

        return $query->getResult();
    }

    public function GetModel($em, $year, $make){
        $query = $em->createQuery(
            'SELECT DISTINCT c FROM AppBundle:Car c WHERE  c.year=:year AND c.make=:make'
        )
            ->setParameter('year',$year)
            ->setParameter('make',$make);

        return $query->getResult();
    }



}