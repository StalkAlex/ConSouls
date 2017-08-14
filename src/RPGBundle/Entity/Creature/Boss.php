<?php
/**
 * Created by PhpStorm.
 * User: stalk
 * Date: 12.08.2017
 * Time: 16:13
 */

namespace RPGBundle\Entity\Creature;


class Boss extends Creature
{
    protected $experienceCost;

    public function __construct(array $actions)
    {
        $this->actions = $actions;
    }

    /**
     * @return mixed
     */
    public function getExperienceCost()
    {
        return $this->experienceCost;
    }
}