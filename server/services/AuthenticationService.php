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

    public function userExists($username)
    {
        $sql = 'SELECT user.username, user.is_admin
                FROM user
                WHERE user.username = ?';

        $stmt = $this->dbConn->prepare($sql);
        $stmt->bind_param('s', $username);
        $stmt->execute();

        return $stmt->get_result()->num_rows > 0;
    }

    public function getUser($username, $password)
    {
        $sql = 'SELECT user.username, user.is_admin, user.password
                FROM user
                WHERE user.username = ?';

        $stmt = $this->dbConn->prepare($sql);
        $stmt->bind_param('s', $username);
        $stmt->execute();

        $user = $stmt->get_result()->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            return [
                'username' => $user['username'],
                'is_admin' => $user['is_admin']
            ];
        } else {
            return null;
        }
    }

    public function signupUser($username, $password, $email)
    {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $sql = 'INSERT INTO user (username, password, email, is_admin)
                VALUES (?, ?, ?, 0)';

        if($stmt = $this->dbConn->prepare($sql)) {
            if(!$stmt->bind_param('sss', $username, $hashedPassword, $email)) {
                return false;//"Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
            }
            if (!$stmt->execute()) {
                return false;//"Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            }

            return true;
        } else {
            return false;//"Prepare statement failed";
        }


    }

}
