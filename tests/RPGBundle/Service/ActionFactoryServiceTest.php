<?php
/**
 * Created by PhpStorm.
 * User: AlexandrAboimov
 * Date: 16.08.2017
 * Time: 12:27
 */

namespace RPGBundle\Service;

use RPGBundle\Entity\Action\FireStorm;
use RPGBundle\Entity\Action\Grasp;
use RPGBundle\Entity\Action\Roll;
use RPGBundle\Entity\Action\Shield;
use RPGBundle\Entity\Action\SwordAttack;
use RPGBundle\Exception\NoActionDefinedException;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

/**
 * Class ActionFactoryServiceTest
 */
class ActionFactoryServiceTest extends TestCase
{
    /**
     * Test factory
     */
    public function testCreateAction()
    {
        $actions = [
            'fireStorm' => new FireStorm(),
            'grasp' => new Grasp(),
            'roll' => new Roll(),
            'swordAttack' => new SwordAttack(),
            'shield' => new Shield(),
        ];
        $factory = new ActionFactoryService();
        foreach ($actions as $code => $action) {
            $actionInstance = $factory->createAction($code);
            $this->assertSame($actionInstance->getCode(), $action->getCode());
        }
        $this->expectException(NoActionDefinedException::class);
        $factory = new ActionFactoryService();
        $factory->createAction('non-existent-action');
    }
}
