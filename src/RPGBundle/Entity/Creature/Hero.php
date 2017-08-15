<?php
/**
 * Created by PhpStorm.
 * User: stalk
 * Date: 12.08.2017
 * Time: 15:51
 */

namespace RPGBundle\Entity\Creature;


/**
 * Class Hero
 * @package RPGBundle\Entity\Creature
 */
class Hero extends Creature
{
    protected $stamina;

    /**
     * Hero constructor.
     * @param array $actions
     */
    public function __construct(array $actions)
    {
        $this->actions = $actions;
    }

    /**
     * @return int
     */
    public function getStamina()
    {
        return $this->stamina;
    }
}