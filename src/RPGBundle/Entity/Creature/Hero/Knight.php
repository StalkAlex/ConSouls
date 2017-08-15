<?php
/**
 * Created by PhpStorm.
 * User: stalk
 * Date: 12.08.2017
 * Time: 19:33
 */

namespace RPGBundle\Entity\Creature\Hero;


use RPGBundle\Entity\Creature\Hero;

class Knight extends Hero
{
    protected $name = 'Knight';
    protected $description = 'Mighty knight with sword and shield';
    protected $stamina = 100;
    protected $health = 100;
    protected $damage = 30;

}