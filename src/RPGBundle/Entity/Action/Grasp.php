<?php
/**
 * Created by PhpStorm.
 * User: stalk
 * Date: 13.08.2017
 * Time: 21:36
 */

namespace RPGBundle\Entity\Action;


use RPGBundle\Entity\Action;

class Grasp extends Action
{
    protected $damage = 60;
    protected $isBlockable = false;
    protected $isRollable = true;
    protected $sound = 'Grrrrr';
}