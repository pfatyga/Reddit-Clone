<?php

namespace reddit_clone\controllers;

use reddit_clone\services\UserService;

/**
 * Class UserController
 *
 * @package reddit_clone\controllers
 */
class UserController
{
    /**
     * @var \reddit_clone\services\UserService
     */
    private $userService;

    function __construct()
    {
        $this->userService = new UserService();
    }

    /**
     * Gets a user.
     *
     * @param array $parameters
     *
     * @return string|null
     */
    public function getUser(array $parameters)
    {
        $username = $parameters['username'];
        $user = $this->userService->getUserByUsername($username);

        if (is_null($user))
        {
            header('Content-Type: application/json');
            return null;
        }

        http_response_code(200);
        header('Content-Type: application/json');
        return json_encode($user->toArray());
    }

    /**
     * Creates a user.
     *
     * @return string|null
     */
    public function createUser()
    {
        $values = array();
        $user = $this->userService->createUser($values);

        if (is_null($user))
        {
            header('Content-Type: application/json');
            return null;
        }

        http_response_code(201);
        header('Content-Type: application/json');
        return json_encode($user->toArray());
    }

    /**
     * Updates user
     *
     * @param array $parameters
     *
     * @return string|null
     */
    public function updateUser(array $parameters)
    {
        $username = $parameters['username'];
        $values = array();
        $user = $this->userService->updateUser($username, $values);

        if (is_null($user))
        {
            http_response_code(404);
            header('Content-Type: application/json');
            return null;
        }

        http_response_code(200);
        header('Content-Type: application/json');
        return json_encode($user->toArray());
    }

    /**
     * Deletes a user.
     *
     * @param array $parameters
     *
     * @return string
     */
    public function deleteUser(array $parameters)
    {
        $username = $parameters['username'];
        $this->userService->deleteUser($username);

        http_response_code(204);
        header('Content-Type: application/json');
        return '';
    }
}