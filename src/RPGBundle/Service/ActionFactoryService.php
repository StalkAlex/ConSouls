<?php
/**
 * Created by PhpStorm.
 * User: stalk
 * Date: 14.08.2017
 * Time: 21:11
 */

namespace RPGBundle\Service;


use RPGBundle\Domain\IActionFactory;
use RPGBundle\Entity\Action\FireStorm;
use RPGBundle\Entity\Action\Grasp;
use RPGBundle\Entity\Action\Roll;
use RPGBundle\Entity\Action\Shield;
use RPGBundle\Entity\Action\SwordAttack;
use RPGBundle\Exception\NoActionDefinedException;

class ActionFactoryService implements IActionFactory
{
    public function createAction($code)
    {
        switch ($code) {
            case 'fireStorm':
                return new FireStorm();
            case 'grasp':
                return new Grasp();
            case 'roll':
                return new Roll();
            case 'shield':
                return new Shield();
            case 'swordAttack':
                return new SwordAttack();
            default:
                throw new NoActionDefinedException('There is no action with this code: ' . $code);
        }
    }

}