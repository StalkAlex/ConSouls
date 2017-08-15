<?php
/**
 * Created by PhpStorm.
 * User: stalk
 * Date: 13.08.2017
 * Time: 21:36
 */

namespace RPGBundle\Entity\Action;


use RPGBundle\Entity\AttackAction;

/**
 * Class Grasp
 * @package RPGBundle\Entity\Action
 */
class Grasp extends AttackAction
{
    protected $damage = 60;
    protected $isBlockable = false;
    protected $isRollable = true;
    protected $sound = 'Grrrrr';
    protected $code = 'grasp';
}