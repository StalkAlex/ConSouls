<?php
namespace RPGBundle\Service;

use RPGBundle\Entity\Action\Roll;
use RPGBundle\Service\Domain\ActionFactoryInterface;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

/**
 * Class ActionServiceTest
 */
class ActionServiceTest extends TestCase
{
    /**
     * Test getAction method
     */
    public function testGetAction()
    {
        $actionFactoryMock = $this->getMockBuilder(ActionFactoryInterface::class)->getMock();
        $actionFactoryMock->expects($this->once())->method('createAction');
        $actionService = new ActionService($actionFactoryMock);
        $actionService->getAction('someAction');
    }

    /**
     * Test if method returns valid defense actions
     */
    public function testGetAvailableDefenseActions()
    {
        $actionFactoryMock = $this->getMockBuilder(ActionFactoryInterface::class)->getMock();
        $actionFactoryMock->expects($this->atLeast(2))
            ->method('createAction')
            ->willReturn(new Roll());
        $actionService = new ActionService($actionFactoryMock);
        $actions = $actionService->getAvailableDefenseActions();
        $this->assertCount(2, $actions);
        $this->assertInstanceOf(Roll::class, $actions[0]);
        $this->assertInstanceOf(Roll::class, $actions[1]);
    }
}
