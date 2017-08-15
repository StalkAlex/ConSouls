<?php
/**
 * Created by PhpStorm.
 * User: stalk
 * Date: 13.08.2017
 * Time: 22:12
 */

namespace RPGBundle\Entity\Creature\Boss;

use RPGBundle\Entity\Creature\Boss;

/**
 * Class FireChampion
 */
class FireChampion extends Boss
{
    protected $experienceCost = 100;
    protected $health = 200;
    protected $damage = 45;
    protected $name = 'Fire Champion';
    protected $description = 'Great champion of fire';
}
