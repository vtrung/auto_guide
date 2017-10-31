<?php
/**
 * Created by PhpStorm.
 * User: Ving
 * Date: 10/30/17
 * Time: 10:11 PM
 */

namespace AppBundle\Form\EventListener;

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
        //$user = $event->getData();
        $user= $event->getData();
        $form = $event->getForm();

        print("onPresetData==");
        var_dump($user);
        //var_dump($user);
        //var_dump($form);
        // Check whether the user from the initial data has chosen to
        // display his email or not.
//        if (true === $user->isShowEmail()) {
            //$form->add('email', EmailType::class);
//        }

    }



    public function onPreSubmit(FormEvent $event)
    {
        print("OnPREsumbit");
        $user = $event->getData();
        $form = $event->getForm();

        var_dump($user);

        $year = $user['year'];
        $make = $user['make'];

        $cu = new CarUtility($this->entityManager);

        if(strlen($make) > 0)
        {

            $models = $cu->GetModel($year, $make);
            $form->add('model', ChoiceType::class, array(
                'choices' => $models,
                'choice_label' => function($model){
                    /** @var Car $model */
                    return $model->getName();
                }
            ));
        }

        if(strlen($year) > 0)
        {
            $makes = $cu->GetMake($year);
            if(!in_array($make, $makes)){
                $form->get('make')->setData("");
            }

            $form->add('make', ChoiceType::class, array(
                'choices' => $makes,
                'choice_label' => function($make){
                    return $make;
                }
            ));
        }
    }
}