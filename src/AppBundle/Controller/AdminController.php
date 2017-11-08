<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use SimpleXMLElement;
use AppBundle\Entity\Car;

class AdminController Extends Controller
{

    /**
     * @Route("/admin")
     */
    public function adminAction(){

        return new Response("Use /admin/import to import latest car data <a href='/admin/import'>import</a>");
    }

    /**
     * @Route("/admin/import")
     */
    public function importAction(){

        $this->updateCars();
        return new Response("Finished");
    }

    private function updateCars(){
        $carid = 1;

        for($i = $carid; $i < $carid + 30000; $i++){


            $check = $this->getDoctrine()
                ->getRepository(Car::class)
                ->findOneBy(array('carid' => $i));

            //var_dump($check);
            if($check != null)
                continue;

            print($i. PHP_EOL);
            echo("......".PHP_EOL);
            $this->getCar($i);

        };
    }

    private function getCar($i){
        $url = "http://www.fueleconomy.gov/ws/rest/vehicle/" . $i;
        $ch = curl_init();
        // replace this example code with whatever you need
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $res = curl_exec($ch);

        try{
            $xml = simplexml_load_string($res) or die("Error: Cannot create object");
            print($xml->id[0].":".$xml->year[0].":".$xml->make[0].":".$xml->model[0]);
            $this->saveCar($xml);
        } catch(Exception $e){

        }
    }

    private function saveCar($xml){
        try {

            $em = $this->getDoctrine()->getManager();

            $car = new Car();
            $car->setCarid($xml->id[0]);
            $car->setMake($xml->make[0]);
            $car->setYear($xml->year[0]);
            $car->setMpg($xml->comb08[0]);
            $car->setModel($xml->model[0]);
            $xml->make[0];

            $em->persist($car);
            $em->flush();
        } catch (Exception $e) {

        }
    }
}