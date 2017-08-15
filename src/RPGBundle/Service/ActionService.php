<?php
/**
 * Created by PhpStorm.
 * User: stalk
 * Date: 14.08.2017
 * Time: 20:10
 */

namespace RPGBundle\Service;

use RPGBundle\Entity\Action;
use RPGBundle\Exception\NoActionDefinedException;
use RPGBundle\Service\Domain\IActionFactory;

/**
 * Class ActionService
 * @package RPGBundle\Service
 */
class ActionService
{
    /** @var IActionFactory $actionFactory */
    private $actionFactory;

    /***
     * ActionService constructor.
     * @param IActionFactory $actionFactory
     */
    public function __construct(IActionFactory $actionFactory)
    {
        $this->actionFactory = $actionFactory;
    }

    /**
     * Returns actions that can be used for defense.
     * @return array
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
     * Returns action by its code
     * @param string $code
     * @return Action
     * @throws \RPGBundle\Exception\NoActionDefinedException
     */
    public function getAction(string $code)
    {
        $action = $this->actionFactory->createAction($code);
        if (!$action) {
            throw new NoActionDefinedException('There is no action with code '.$code.' defined.');
        }
        return $action;
    }
}
