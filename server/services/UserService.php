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

    private $dbConn;

    function __construct()
    {
        global $config;

        $this->dbConn = mysqli_connect($config['db']['host'], $config['db']['username'], $config['db']['password'], $config['db']['name']);
    }

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


    public function userExists($username) {
        $stmt = $this->dbConn->prepare('SELECT * FROM user WHERE user.username = ?');
        $stmt->bind_param('s', $username);
        $stmt->execute();

        return $stmt->get_result()->num_rows > 0;
    }

    public function getUserPosts($user) {
        $stmt = $this->dbConn->prepare('SELECT P.post_id, title, timestamp, author, url, imageUrl, subreddit, CONVERT(COALESCE(SUM(UPV.type), 0), UNSIGNED) AS upVotes, CONVERT(COALESCE(COUNT(UPV.type)-SUM(UPV.type), 0), UNSIGNED) AS downVotes FROM post P LEFT JOIN user_post_vote UPV ON P.post_id = UPV.post_id WHERE P.author = ? GROUP BY P.post_id HAVING P.post_id IS NOT NULL');
        $stmt->bind_param('s', $user);
        $stmt->execute();

        $result = $stmt->get_result();
        $rows = array();
        while($array = $result->fetch_assoc()){
            $rows[] = $array;
        }

        return $rows;
    }

    public function getUserComments($user) {
        $stmt = $this->dbConn->prepare('SELECT C.comment_id, timestamp, author, content, parent_comment_id, post_id, CONVERT(COALESCE(SUM(UCV.type), 0), UNSIGNED) AS upVotes, CONVERT(COALESCE(COUNT(UCV.type)-SUM(UCV.type), 0), UNSIGNED) AS downVotes FROM comment C LEFT JOIN user_comment_vote UCV ON C.comment_id = UCV.comment_id WHERE C.author = ? GROUP BY C.comment_id HAVING C.comment_id IS NOT NULL');
        $stmt->bind_param('s', $user);
        $stmt->execute();

        $result = $stmt->get_result();
        $rows = array();
        while($array = $result->fetch_assoc()){
            $rows[] = $array;
        }

        return $rows;
    }

}
