<?php

namespace reddit_clone\controllers;

/**
 * Class ApiController
 *
 * @package reddit_clone\controllers
 */
class ApiController
{
    public function getApi()
    {
        header('Content-Type: application/json');
        return '{}';
    }
}