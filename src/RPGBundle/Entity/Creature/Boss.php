<?php
/**
 * Created by PhpStorm.
 * User: stalk
 * Date: 12.08.2017
 * Time: 16:13
 */

namespace RPGBundle\Entity\Creature;


/**
 * Class Boss
 * @package RPGBundle\Entity\Creature
 */
class Boss extends Creature
{
    protected $experienceCost;

    /**
     * Boss constructor.
     * @param array $actions
     */
    public function __construct(array $actions)
    {
        $this->actions = $actions;
    }

    /**
     * @return int
     */
    public function getExperienceCost()
    {
        return $this->experienceCost;
    }
}