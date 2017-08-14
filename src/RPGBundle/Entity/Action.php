<?php
/**
 * Created by PhpStorm.
 * User: AlexandrAboimov
 * Date: 14.08.2017
 * Time: 10:47
 */

namespace RPGBundle;


abstract class Action
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