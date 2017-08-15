<?php
/**
 * Created by PhpStorm.
 * User: stalk
 * Date: 13.08.2017
 * Time: 21:42
 */

namespace RPGBundle\Entity\Action;


/**
 * Class FireStorm
 */
class FireStorm extends AttackAction
{
    protected $damage = 100;
    protected $isBlockable = false;
    protected $isRollable = false;
    protected $sound = 'Bams!';
    protected $code = 'fireStorm';
}
