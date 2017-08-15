<?php
/**
 * Created by PhpStorm.
 * User: stalk
 * Date: 11.08.2017
 * Time: 20:35
 */

namespace RPGBundle\Entity;


/**
 * Class AttackAction
 * @package RPGBundle\Entity
 */
class AttackAction extends Action
{
    protected $isRollable;
    protected $isBlockable;
    protected $damage;
    protected $sound;

    /**
     * @return bool
     */
    public function getIsRollable()
    {
        return $this->isRollable;
    }

    /**
     * @return bool
     */
    public function getIsBlockable()
    {
        return $this->isBlockable;
    }

    /**
     * @return int
     */
    public function getDamage()
    {
        return $this->damage;
    }

    /**
     * @return string
     */
    public function getSound()
    {
        return $this->sound;
    }

}