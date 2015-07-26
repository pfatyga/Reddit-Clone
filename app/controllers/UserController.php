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
     * @return array|null
     */
    public function getUser(array $parameters)
    {
        $userId = $parameters['userId'];
        $user = $this->userService->getUser($userId);

        if (is_null($user))
        {
            return null;
        }

        http_response_code(200);
        return json_encode($user->toArray());
    }

    /**
     * Creates a user.
     *
     * @return array|null
     */
    public function createUser()
    {
        $values = array();
        $user = $this->userService->createUser($values);

        if (is_null($user))
        {
            return null;
        }

        http_response_code(201);
        return json_encode($user->toArray());
    }

    /**
     * Updates user
     *
     * @param array $parameters
     *
     * @return array|null
     */
    public function updateUser(array $parameters)
    {
        $userId = $parameters['userId'];
        $values = array();
        $user = $this->userService->updateUser($userId, $values);

        if (is_null($user))
        {
            return null;
        }

        http_response_code(200);
        return json_encode($user->toArray());
    }

    /**
     * Deletes a user.
     *
     * @param array $parameters
     *
     * @return null
     */
    public function deleteUser(array $parameters)
    {
        $userId = $parameters['userId'];
        $this->userService->deleteUser($userId);

        http_response_code(204);
        return '';
    }
}