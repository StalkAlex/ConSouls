<?php
/**
 * Created by PhpStorm.
 * User: AlexandrAboimov
 * Date: 14.08.2017
 * Time: 10:47
 */

namespace RPGBundle\Entity\Action;

/**
 * Class Action
 */
abstract class AbstractAction
{
    protected $code;

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }
}
