<?php

namespace App;
/**
 * Trait Singletone
 * @package App
 * Реализует паттерн Singletone
 */
trait Singletone
{

    protected static $instance;

    private function __construct()
    {
    }

    static public function getInstace()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }
        return static::$instance;
    }

}