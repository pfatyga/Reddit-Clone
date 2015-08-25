<?php

namespace reddit_clone\services;
use reddit_clone\models\Post;

/**
 * Class SubredditService
 *
 * Contains CRUD methods for subreddits.
 *
 * @package reddit_clone\services
 */
class SubredditService
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

    public function getFrontpage()
    {
        $stmt = $this->dbConn->prepare('SELECT P.post_id, title, when_created, author, subreddit, SUM(UPV.type) AS upVotes, COUNT(UPV.type)-SUM(UPV.type) AS downVotes FROM post P, user_post_vote UPV WHERE P.post_id = UPV.post_id');
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();

    }

}
