<?php
/**
 * Created by PhpStorm.
 * User: stalk
 * Date: 14.08.2017
 * Time: 20:10
 */

namespace RPGBundle\Service;

use RPGBundle\Entity\Action\AbstractAction;
use RPGBundle\Exception\NoActionDefinedException;
use RPGBundle\Service\Domain\ActionFactoryInterface;

/**
 * Class ActionService
 */
class ActionService
{
    /** @var ActionFactoryInterface $actionFactory */
    private $actionFactory;

    /**
     * ActionService constructor.
     *
     * @param ActionFactoryInterface $actionFactory
     */
    public function __construct(ActionFactoryInterface $actionFactory)
    {
        $this->actionFactory = $actionFactory;
    }

    /**
     * Returns actions that can be used for defense.
     *
     * @return array
     *
     * @throws \RPGBundle\Exception\NoActionDefinedException
     */
    public function getAvailableDefenseActions()
    {
        return [
            $this->getAction('roll'),
            $this->getAction('shield'),
        ];
    }

    /**
     * Returns action by its code.
     *
     * @param string $code
     *
     * @return AbstractAction
     *
     * @throws \RPGBundle\Exception\NoActionDefinedException
     */
    public function getAction(string $code)
    {
        return $this->actionFactory->createAction($code);
    }
}
