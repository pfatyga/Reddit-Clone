<?php

$config = array(
    'db' => array(
        'name' => 'reddit_clone',
        'host' => '127.0.0.1',
        'username' => 'user',
        'password' => 'pass'
    ),
    'routes' => array(
        array(
            'path' => '/api',
            'method' => 'GET',
            'controller' => '\reddit_clone\controllers\ApiController::getApi'
        ),
        array(
            'path' => '/api/users/:username',
            'method' => 'GET',
            'controller' => '\reddit_clone\controllers\UserController::getUser'
        ),
        array(
            'path' => '/api/users',
            'method' => 'GET',
            'controller' => '\reddit_clone\controllers\UserController::createUser'
        ),
        array(
            'path' => '/api/users/:username',
            'method' => 'PUT',
            'controller' => '\reddit_clone\controllers\UserController::updateUser'
        ),
        array(
            'path' => '/api/users/:username',
            'method' => 'DELETE',
            'controller' => '\reddit_clone\controllers\UserController::deleteUser'
        ),
        array(
            'path' => '/api/subreddits',
            'method' => 'GET',
            'controller' => '\reddit_clone\controllers\SubredditController::getSubreddits'
        ),
        array(
            'path' => '/api/subreddits/:name',
            'method' => 'GET',
            'controller' => '\reddit_clone\controllers\SubredditController::getSubreddit'
        )
    )
);
