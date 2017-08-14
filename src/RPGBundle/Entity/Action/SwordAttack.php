<?php
/**
 * Created by PhpStorm.
 * User: stalk
 * Date: 13.08.2017
 * Time: 21:27
 */

namespace RPGBundle\Entity\Action;


use RPGBundle\Entity\AttackAction;

class SwordAttack extends AttackAction
{
    protected $damage = 40;
    protected $isRollable = true;
    protected $isBlockable = true;
    protected $sound = 'Arghhh';
    protected $code = 'swordAttack';
}