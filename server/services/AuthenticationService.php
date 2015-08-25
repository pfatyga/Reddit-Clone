<?php

namespace reddit_clone\services;

/**
 * Class SubredditService
 *
 * Contains CRUD methods for subreddits.
 *
 * @package reddit_clone\services
 */
class AuthenticationService
{
    /**
     * Gets the Frontpage
     *
     * @return array
     */

     private $dbConn;

     function __construct()
     {
         global $config;

         $this->dbConn = mysqli_connect($config['db']['host'], $config['db']['username'], $config['db']['password'], $config['db']['name']);
     }

    public function getUser($username, $password)
    {
        $stmt = $this->dbConn->prepare('SELECT user.username, user.is_admin FROM user WHERE user.username = ? AND user.password = ?');
        $stmt->bind_param('ss', $username, $password);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();

    }

}
