<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Car;
use Doctrine\ORM\Query\Expr\Select;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Utility\CarUtility;


class AutoController Extends Controller
{
    /**
     * @Route("/", name="auto_landing")
     */
    public function indexAction(Request $request){

        $cu = new CarUtility();
        $em = $this->getDoctrine()->getManager();
        $years = $cu->GetAllYears($em);
        var_dump($years);
        $form = $this->createFormBuilder()
            ->add('year', ChoiceType::class, array(
                'choices' => $years,
                'choice_label' => function($year){
                    return $year;
                }
            ))
            ->add('save', SubmitType::class, array('label' => 'Next'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $year = $form->getData()['year'];
            return $this->redirectToRoute('auto_year_landing', [
                'year' => $year
            ]);
        };


        return $this->render('auto/index.html.twig', [
            'title' => "Auto Guide Efficiency Calculator",
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/car/{year}", name="auto_year_landing")
     */
    public function carYearAction(Request $request, $year){
        $cu = new CarUtility();
        $em = $this->getDoctrine()->getManager();
        $makes = $cu->GetMake($em, $year);

        $form = $this->createFormBuilder()

            ->add('make', ChoiceType::class, array(
                'choices' => $makes,
                'choice_label' => function($make){
                    return $make;
                }
            ))
            ->add('save', SubmitType::class, array('label' => 'Next'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $make = $form->getData()['make'];
            return $this->redirectToRoute('auto_make_landing', [
                'year' => $year,
                'make' => $make
            ]);
        };


        return $this->render('auto/index.html.twig', [
            'year' => $year,
            'title' => "Auto Guide Efficiency Calculator",
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/car/{year}/{make}", name="auto_make_landing")
     */
    public function carMakeAction(Request $request, $year, $make){
        $cu = new CarUtility();
        $em = $this->getDoctrine()->getManager();
        $models = $cu->GetModel($em, $year, $make);

        $form = $this->createFormBuilder()

            ->add('model', ChoiceType::class, array(
                'choices' => $models,
                'choice_label' => function($model){
                    /** @var Car $model */
                    return $model->getName();
                }
            ))
            ->add('save', SubmitType::class, array('label' => 'Next'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Car $model */
            $model = $form->getData()['model'];
            return $this->redirectToRoute('auto_car_landing', [
                'id' => $model->getId()
            ]);
        };


        return $this->render('auto/index.html.twig', [
            'year' => $year,
            'title' => "Auto Guide Efficiency Calculator",
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/carindex/{id}", name="auto_car_landing")
     */
    public function carAction(Request $request, $id){
        /** @var Car $model */
        $car = $this->getDoctrine()
            ->getRepository(Car::class)
            ->findById($id)[0];

        var_dump($car);

        return $this->render('auto/carindex.html.twig', [
            'car' => $car,
            'title' => $car->getName()
        ]);
    }

    /**
     * @Route("/compare", name="auto_compare_landing")
     */
    public function compareAction(Request $request){
//        $cars = [
//            (new Car())->setYear('2005')->setMake('Toyota')->setModel('Corolla')->setMpg(28),
//            (new Car())->setYear('2015')->setMake('Toyota')->setModel('Prius V')->setMpg(41),
//            (new Car())->setYear('2008')->setMake('Hummer')->setModel('H3')->setMpg(15),
//            (new Car())->setYear('2017')->setMake('Ford')->setModel('Mustang')->setMpg(24)
//        ];


        $cars = $this->getDoctrine()
            ->getRepository(Car::class)
            ->findAll();


        $compare = [];
        $compare_mpg = 0;

        $form = $this->createFormBuilder()
            ->add('carLeft', ChoiceType::class, array(
                'choices' => $cars,
                'choice_label' => function($car){
                    /** @var Car $cat */
                    return $car->getName();
                }
            ))
            ->add('carRight', ChoiceType::class, array(
                'choices' => $cars,
                'choice_label' => function($car){
                    /** @var Car $cat */
                    return $car->getName();
                }
            ))
            ->add('save', SubmitType::class, array('label' => 'Compare'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $left = $form->getData()['carLeft'];
            $right = $form->getData()['carRight'];
            $compare_mpg = (new CarUtility())->Compare($left, $right);
            array_push($compare, $left);
            array_push($compare, $right);
            //return $this->redirectToRoute('task_success');
        }


        return $this->render('auto/compare.html.twig', [
            'title' => "Auto Guide Efficiency Calculator",
            'cars' => $cars,
            'form' => $form->createView(),
            'compare' => $compare,
            'comparempg' => $compare_mpg
        ]);
    }
//
//    /**
//     * @Route("/auto/api/year", name="auto_api_year")
//     * @Method("GET")
//     */
//    public function apiYearAction(){
//        $cu = new CarUtility();
//        return new Response(json_encode($cu->GetAllYears()));
//    }
//
//    /**
//     * @Route("/auto/api/{year}", name="auto_api_year")
//     * @Method("GET")
//     */
//    public function apiMakeAction($year){
//        $cu = new CarUtility();
//        return new Response(json_encode($cu->GetMake($year)));
//    }
//
//    /**
//     * @Route("/auto/api/{year}/{make}", name="auto_api_year")
//     * @Method("GET")
//     */
//    public function apiModelAction($year, $make){
//        $cu = new CarUtility();
//        return new Response(json_encode($cu->GetModel($year, $make)));
//    }

}