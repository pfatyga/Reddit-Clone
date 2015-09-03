<?php

$config = array(
    'db' => array(
        'name' => 'leddit',
        'host' => '127.0.0.1',
        'username' => 'leddit',
        'password' => 'temp1234'
    ),
    'routes' => array(
        array(
            'path' => '/api',
            'method' => 'GET',
            'controller' => '\reddit_clone\controllers\ApiController::getApi'
        ),
        array(
            'path' => '/api/posts',
            'method' => 'GET',
            'controller' => '\reddit_clone\controllers\SubredditController::GetFrontPage'
        ),
        array(
            'path' => '/api/signup',
            'method' => 'POST',
            'controller' => '\reddit_clone\controllers\AuthenticationController::signup'
        ),
        array(
            'path' => '/api/login',
            'method' => 'POST',
            'controller' => '\reddit_clone\controllers\AuthenticationController::login'
        ),
        array(
            'path' => '/api/logout',
            'method' => 'GET',
            'controller' => '\reddit_clone\controllers\AuthenticationController::logout'
        ),
        array(
            'path' => '/api/authenticateSession',
            'method' => 'GET',
            'controller' => '\reddit_clone\controllers\AuthenticationController::authenticate'
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
            'path' => '/api/subreddits/:name/create',
            'method' => 'POST',
            'controller' => '\reddit_clone\controllers\SubredditController::createSubreddit'
        ),
        array(
            'path' => '/api/subreddits/:name',
            'method' => 'GET',
            'controller' => '\reddit_clone\controllers\SubredditController::getSubreddit'
        ),
        array(
            'path' => '/api/subreddits/:name/new',
            'method' => 'POST',
            'controller' => '\reddit_clone\controllers\SubredditController::newPost'
        ),
        array(
            'path' => '/api/subreddits/:name/posts/:id',
            'method' => 'GET',
            'controller' => '\reddit_clone\controllers\SubredditController::getPost'
        ),
        array(
            'path' => '/api/subreddits/:name/posts/:id/new',
            'method' => 'POST',
            'controller' => '\reddit_clone\controllers\SubredditController::newComment'
        ),
        array(
            'path' => '/api/subreddits/:name/posts/:post_id/comments/:comment_id/new',
            'method' => 'POST',
            'controller' => '\reddit_clone\controllers\SubredditController::newCommentReply'
        ),
        array(
            'path' => '/api/subreddits/:name/posts/:id/upvote',
            'method' => 'POST',
            'controller' => '\reddit_clone\controllers\SubredditController::upVotePost'
        ),
        array(
            'path' => '/api/subreddits/:name/posts/:id/downvote',
            'method' => 'POST',
            'controller' => '\reddit_clone\controllers\SubredditController::downVotePost'
        )
    )
);
