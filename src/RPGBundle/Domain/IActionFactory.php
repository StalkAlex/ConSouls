<?php
/**
 * Created by PhpStorm.
 * User: stalk
 * Date: 14.08.2017
 * Time: 21:10
 */

namespace RPGBundle\Domain;


interface IActionFactory
{
    public function createAction($code);
}