<?php
/**
 * Created by PhpStorm.
 * User: stalk
 * Date: 14.08.2017
 * Time: 20:10
 */

namespace RPGBundle\Service;


use RPGBundle\Service\Domain\IActionFactory;

class ActionService
{
    /** @var IActionFactory $actionFactory */
    private $actionFactory;

    public function __construct(IActionFactory $actionFactory)
    {
        $this->actionFactory = $actionFactory;
    }

    /**
     * @return array
     */
    public function getAvailableDefenseActions()
    {
        return [
            $this->getAction('roll'),
            $this->getAction('shield'),
        ];
    }

    public function getAction(string $code)
    {
        return $this->actionFactory->createAction($code);
    }
}