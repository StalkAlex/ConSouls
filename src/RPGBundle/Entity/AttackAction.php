<?php
/**
 * Created by PhpStorm.
 * User: stalk
 * Date: 11.08.2017
 * Time: 20:35
 */

namespace RPGBundle\Entity;


class AttackAction extends Action
{
    protected $isRollable;
    protected $isBlockable;
    protected $damage;
    protected $sound;

    /**
     * @return mixed
     */
    public function getIsRollable()
    {
        return $this->isRollable;
    }

    /**
     * @return mixed
     */
    public function getIsBlockable()
    {
        return $this->isBlockable;
    }

    /**
     * @return mixed
     */
    public function getDamage()
    {
        return $this->damage;
    }

    /**
     * @return mixed
     */
    public function getSound()
    {
        return $this->sound;
    }

}