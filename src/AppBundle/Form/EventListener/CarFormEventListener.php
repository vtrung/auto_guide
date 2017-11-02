<?php
/**
 * Created by PhpStorm.
 * User: Ving
 * Date: 10/30/17
 * Time: 10:11 PM
 */

namespace AppBundle\Form\EventListener;

use AppBundle\Entity\Car;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use AppBundle\Utility\CarUtility;



class CarFormEventListener implements EventSubscriberInterface
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA => 'onPreSetData',
            FormEvents::PRE_SUBMIT   => 'onPreSubmit',
        );
    }

    public function onPreSetData(FormEvent $event)
    {


    }



    public function onPreSubmit(FormEvent $event)
    {
        print("OnPREsumbit");
        $data = $event->getData();
        $form = $event->getForm();

        $year = $data['year'];
        $make = '';
        if(array_key_exists ( 'make' , $data )){
            $make = $data['make'];
        }


        if(strlen($make) > 0)
        {
            $models = $makes = $this->entityManager->getRepository(Car::class)->findModels($year, $make);
            array_unshift ( $models, null );
            $form->add('model', ChoiceType::class, array(
                'choices' => $models,
                'choice_label' => function(Car $model = null){
                    /** @var Car $model */
                    return $model ? $model->getName(): '';
                }
            ));
        }

        if(strlen($year) > 0)
        {
            $makes = $this->entityManager->getRepository(Car::class)->findMakes($year);
            array_unshift ( $makes, null );
            $form->add('make', ChoiceType::class, array(
                'choices' => $makes,
                'choice_label' => function(Car $make = null){
                    return $make ? $make->getMake() : '';
                },
                'choice_value' => function(Car $make = null){
                    return $make ? $make->getMake() : '';
                }
            ));
        }
    }
}