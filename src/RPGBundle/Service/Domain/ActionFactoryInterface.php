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
 * Interface ActionFactoryInterface
 */
interface ActionFactoryInterface
{
    /**
     * @param string $code
     *
     * @return mixed
     */
    public function createAction(string $code);
}
