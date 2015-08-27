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
        $stmt = $this->dbConn->prepare('SELECT P.post_id, title, when_created, author, subreddit, SUM(UPV.type) AS upVotes, COUNT(UPV.type)-SUM(UPV.type) AS downVotes FROM post P, user_post_vote UPV WHERE P.post_id = UPV.post_id HAVING P.post_id IS NOT NULL');
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();

    }

    public function newPost($subreddit, $title, $content, $url, $imageUrl, $user) {
        if($stmt = $this->dbConn->prepare('INSERT INTO post (subreddit, title, content, url, imageUrl, author) VALUES (?, ?, ?, ?, ?, ?)')) {
            if(!$stmt->bind_param('ssssss', $subreddit, $title, $content, $url, $imageUrl, $user)) {
                return false;//"Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
            }
            if (!$stmt->execute()) {
                return false;//"Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            }

            return $stmt->insert_id;
        } else {
            return false;//"Prepare statement failed";
        }
    }

}
