<?php
/**
 * Created by PhpStorm.
 * User: stalk
 * Date: 12.08.2017
 * Time: 15:48
 */

namespace RPGBundle\Entity\Creature;

/**
 * Class Creature
 * @package RPGBundle\Entity\Creature
 */
abstract class Creature
{
    protected $name;
    protected $description;
    protected $health;
    protected $damage;
    protected $actions = [];

    /**
     * @param int $health
     */
    public function setHealth($health)
    {
        $this->health = $health;
    }

    /**
     * @return int
     */
    public function getHealth()
    {
        return $this->health;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return int
     */
    public function getDamage()
    {
        return $this->damage;
    }

    /**
     * @return array
     */
    public function getActions()
    {
        return $this->actions;
    }
}
