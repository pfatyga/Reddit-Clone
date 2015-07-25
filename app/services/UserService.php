<?php

namespace reddit_clone\services;

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
    public function getUser($id)
    {
        // @todo get user from database
        return null;
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