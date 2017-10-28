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
        $cars = [
            (new Car())->setYear('2005')->setMake('Toyota')->setModel('Corolla')->setMpg(28),
            (new Car())->setYear('2015')->setMake('Toyota')->setModel('Prius V')->setMpg(41),
            (new Car())->setYear('2008')->setMake('Hummer')->setModel('H3')->setMpg(15),
            (new Car())->setYear('2017')->setMake('Ford')->setModel('Mustang')->setMpg(24)

        ];

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


        return $this->render('auto/index.html.twig', [
            'title' => "Auto Guide Efficiency Calculator",
            'cars' => $cars,
            'form' => $form->createView(),
            'compare' => $compare,
            'comparempg' => $compare_mpg
        ]);
    }



}