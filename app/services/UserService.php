<?php

namespace reddit_clone\services;
use reddit_clone\models\User;

/**
 * Class UserService
 *
 * Contains CRUD methods for users.
 *
 * @package reddit_clone\services
 */
class UserService
{
    /**
     * Gets the user with the given id.
     *
     * @param int $id
     *
     * @return \reddit_clone\models\User
     */
    public function getUserById($id)
    {
        // @todo get user from database
        return null;
    }

    /**
     * Gets the user with the given username.
     *
     * @param string $username
     *
     * @return \reddit_clone\models\User
     */
    public function getUserByUsername($username)
    {
        // @todo get user from database
        $user = new User();
        $user
            ->setId(1)
            ->setUsername($username)
            ->setPassword('password')
            ->setEmail('test@gmail.com')
            ->setIsAdmin(false);

        return $user;
    }

    /**
     * Creates user with given values.
     *
     * @param array $values
     *
     * @return \reddit_clone\models\User
     */
    public function createUser(array $values)
    {
        // @todo create user
        return null;
    }

    /**
     * Updates user with given values.
     *
     * @param $id
     * @param array $values
     *
     * @return \reddit_clone\models\User
     */
    public function updateUser($id, array $values)
    {
        // @todo get and update user
        return null;
    }

    /**
     * Deletes user with given id.
     *
     * @param $id
     *
     * @return null
     */
    public function deleteUser($id)
    {
        // @todo delete user
        return null;
    }
}