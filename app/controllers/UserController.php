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
     * @return array|null
     */
    public function getUser()
    {
        $userId = 0;
        $user = $this->userService->getUser($userId);

        if (is_null($user))
        {
            return null;
        }

        return $user->toArray();
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

        return $user->toArray();
    }

    /**
     * Updates user
     *
     * @return array|null
     */
    public function updateUser()
    {
        $userId = 0;
        $values = array();
        $user = $this->userService->updateUser($userId, $values);

        if (is_null($user))
        {
            return null;
        }

        return $user->toArray();
    }

    /**
     * Deletes a user.
     *
     * @return null
     */
    public function deleteUser($id)
    {
        $userId = 0;
        $this->userService->deleteUser($userId);
    }
}