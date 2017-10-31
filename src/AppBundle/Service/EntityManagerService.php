<?php
/**
 * Created by PhpStorm.
 * User: Ving
 * Date: 10/30/17
 * Time: 11:07 PM
 */

namespace AppBundle\Service;


use Doctrine\ORM\EntityManager;

class EntityManagerService
{
    private $entitymanager;

    private function __construct(EntityManager $entityManager)
    {
        $this->entitymanager = $entityManager;
    }
}