<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Car
 *
 * @ORM\Table(name="car")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CarRepository")
 */
class Car
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="carid", type="integer", unique=true)
     */
    private $carid;

    /**
     * @var string
     *
     * @ORM\Column(name="year", type="string", length=255)
     */
    private $year;

    /**
     * @var string
     *
     * @ORM\Column(name="make", type="string", length=255)
     */
    private $make;

    /**
     * @var string
     *
     * @ORM\Column(name="model", type="string", length=255)
     */
    private $model;

    /**
     * @var string
     *
     * @ORM\Column(name="mpg", type="string", length=255)
     */
    private $mpg;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set carid
     *
     * @param integer $carid
     *
     * @return Car
     */
    public function setCarid($carid)
    {
        $this->carid = $carid;

        return $this;
    }

    /**
     * Get carid
     *
     * @return int
     */
    public function getCarid()
    {
        return $this->carid;
    }

    /**
     * Set year
     *
     * @param string $year
     *
     * @return Car
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return string
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set make
     *
     * @param string $make
     *
     * @return Car
     */
    public function setMake($make)
    {
        $this->make = $make;

        return $this;
    }

    /**
     * Get make
     *
     * @return string
     */
    public function getMake()
    {
        return $this->make;
    }

    /**
     * Set model
     *
     * @param string $model
     *
     * @return Car
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get model
     *
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set mpg
     *
     * @param string $mpg
     *
     * @return Car
     */
    public function setMpg($mpg)
    {
        $this->mpg = $mpg;

        return $this;
    }

    /**
     * Get mpg
     *
     * @return string
     */
    public function getMpg()
    {
        return $this->mpg;
    }


    public function getName()
    {
        return $this->year . " " . $this->make . " " . $this->model;
    }
}

