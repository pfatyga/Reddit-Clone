<?php

$config = array(
    'db' => array(
        'name' => 'reddit_clone',
        'host' => '127.0.0.1',
        'username' => 'user',
        'password' => 'pass'
    ),
    'templatePath' => 'app/templates',
    'routes' => array(
        array(
            'path' => '/',
            'method' => 'GET',
            'controller' => '\reddit_clone\controllers\HomeController::getHome'
        ),
        array(
            'path' => '/r/{subreddit}',
            'method' => 'GET',
            'controller' => '\reddit_clone\controllers\SubredditController::getSubreddit'
        ),
        array(
            'path' => '/api',
            'method' => 'GET',
            'controller' => '\reddit_clone\controllers\ApiController::getApi'
        ),
    )
);
