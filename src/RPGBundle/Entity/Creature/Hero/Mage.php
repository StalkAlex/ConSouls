<?php
/**
 * Created by PhpStorm.
 * User: stalk
 * Date: 12.08.2017
 * Time: 19:33
 */

namespace RPGBundle\Entity\Creature\Hero;


use RPGBundle\Entity\Creature\Hero;

/**
 * Class Mage
 * @package RPGBundle\Entity\Creature\Hero
 */
class Mage extends Hero
{
    protected $name = 'Mage';
    protected $description = 'Mighty wizard';
    protected $stamina = 50;
    protected $health = 100;
    protected $damage = 30;
}