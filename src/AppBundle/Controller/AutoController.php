<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AutoController Extends Controller
{
    /**
     * @Route("/", name="auto_landing")
     */
    public function indexAction(){
        $cars = [
            ['id' => 1, 'year' => '2005', 'make' => 'Toyota', 'model' => 'Corolla', 'mpg' => 28],
            ['id' => 2, 'year' => '2015', 'make' => 'Toyota', 'model' => 'Prius V', 'mpg' => 40]
        ];

        $data = [
            'title' => "Hello Auto Guide",
            'cars' => $cars
        ];


        return $this->render('auto/index.html.twig', $data);
        //return new Response("Hello Auto Guide");
    }

    
    /**
     * @Route("/compare", name="auto_compare")
     */
    public function compareAction(Request $request){
        $cars = [
            ['id' => 1, 'year' => '2005', 'make' => 'Toyota', 'model' => 'Corolla', 'mpg' => 28],
            ['id' => 2, 'year' => '2015', 'make' => 'Toyota', 'model' => 'Prius V', 'mpg' => 40]
        ];

        $data = [
            'title' => "Hello Auto Compare",
            'cars' => $cars
        ];


        return $this->render('auto/index.html.twig', $data);
        //return new Response("Hello Auto Guide");


    }

}