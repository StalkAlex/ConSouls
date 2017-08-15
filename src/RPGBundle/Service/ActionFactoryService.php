<?php
/**
 * Created by PhpStorm.
 * User: stalk
 * Date: 14.08.2017
 * Time: 21:11
 */

namespace RPGBundle\Service;

use RPGBundle\Entity\Action\AbstractAction;
use RPGBundle\Entity\Action\FireStorm;
use RPGBundle\Entity\Action\Grasp;
use RPGBundle\Entity\Action\Roll;
use RPGBundle\Entity\Action\Shield;
use RPGBundle\Entity\Action\SwordAttack;
use RPGBundle\Exception\NoActionDefinedException;
use RPGBundle\Service\Domain\InterfaceActionFactory;

/**
 * Class ActionFactoryService
 */
class ActionFactoryService implements InterfaceActionFactory
{
    /**
     * Creates action instance by its code
     *
     * @param $code
     * @return AbstractAction
     * @throws NoActionDefinedException
     */
    public function createAction(string $code)
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
                throw new NoActionDefinedException(sprintf('There is no action with this code: %s', $code));
        }
    }
}
