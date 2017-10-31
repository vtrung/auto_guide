<?php
/**
 * Created by PhpStorm.
 * User: Ving
 * Date: 10/28/17
 * Time: 4:26 PM
 */

namespace AppBundle\Utility;

use AppBundle\Entity\Car;
use Doctrine\ORM\EntityManagerInterface;

class CarUtility
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function Compare(Car $car1, Car $car2){

        $mpg = 0;

        $mpg = $car1->getMpg() - $car2->getMpg();

        return $mpg;

    }


    public function GetAllYears(){
        $query = $this->entityManager->createQuery(
            'SELECT DISTINCT c.year FROM AppBundle:Car c ORDER BY c.year DESC '
        );
        return $query->getResult();
    }

    public function GetMake($year){
        $query = $this->entityManager->createQuery(
            'SELECT DISTINCT c.make 
              FROM AppBundle:Car c 
              WHERE c.year=:year
              ORDER BY c.make'
        )->setParameter('year', $year);

        return $query->getResult();
    }
    public function GetModel($year, $make){
        $query = $this->entityManager->createQuery(
            'SELECT DISTINCT c FROM AppBundle:Car c WHERE  c.year=:year AND c.make=:make'
        )
            ->setParameter('year',$year)
            ->setParameter('make',$make);

        return $query->getResult();
    }



}