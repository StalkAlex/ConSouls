<?php
/**
 * Created by PhpStorm.
 * User: stalk
 * Date: 14.08.2017
 * Time: 21:10
 */

namespace RPGBundle\Service\Domain;

/**
 * Factory for creating attacking and defending actions in game like roll
 * Interface IActionFactory
 * @package RPGBundle\Service\Domain
 */
interface IActionFactory
{
    public function createAction($code);
}
