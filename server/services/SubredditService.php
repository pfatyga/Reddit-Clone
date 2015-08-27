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
        $stmt = $this->dbConn->prepare('SELECT P.post_id, title, timestamp, author, subreddit, CONVERT(COALESCE(SUM(UPV.type), 0), UNSIGNED) AS upVotes, CONVERT(COALESCE(COUNT(UPV.type)-SUM(UPV.type), 0), UNSIGNED) AS downVotes FROM post P LEFT JOIN user_post_vote UPV ON P.post_id = UPV.post_id GROUP BY P.post_id HAVING P.post_id IS NOT NULL');
        $stmt->execute();

        $result = $stmt->get_result();
        $rows = array();
        while($array = $result->fetch_assoc()){
            $rows[] = $array;
        }

        return $rows;

    }

    public function addModerator($subreddit, $username) {
        if($stmt = $this->dbConn->prepare('INSERT INTO user_subreddit_moderator (username, subreddit) VALUES (?, ?)')) {
            if(!$stmt->bind_param('ss', $username, $subreddit)) {
                echo 'a';
                return false;//"Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
            }
            if (!$stmt->execute()) {
                echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
                return false;//
            }

            return true;
        } else {
            echo 'c';
            return false;//"Prepare statement failed";
        }
    }

    public function addSubscriber($subreddit, $username) {
        if($stmt = $this->dbConn->prepare('INSERT INTO user_subreddit_subscription (username, subreddit) VALUES (?, ?)')) {
            if(!$stmt->bind_param('ss', $username, $subreddit)) {
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

    public function createSubreddit($subreddit) {
        if($stmt = $this->dbConn->prepare('INSERT INTO subreddit (name) VALUES (?)')) {
            if(!$stmt->bind_param('s', $subreddit)) {
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

    public function subredditExists($subreddit) {
        $stmt = $this->dbConn->prepare('SELECT * FROM subreddit WHERE subreddit.name = ?');
        $stmt->bind_param('s', $subreddit);
        $stmt->execute();

        return $stmt->get_result()->num_rows > 0;
    }

    public function getCountSubredditSubscribers() {
        $stmt = $this->dbConn->prepare('SELECT COUNT(*) AS count FROM `user_subreddit_subscription` WHERE subreddit = ?');
        $stmt->bind_param('s', $subreddit);
        $stmt->execute();

        return $stmt->get_result()->fetch_object()->count;
    }

    public function getSubredditModerators($subreddit) {
        $stmt = $this->dbConn->prepare('SELECT username FROM `user_subreddit_moderator` WHERE subreddit = ?');
        $stmt->bind_param('s', $subreddit);
        $stmt->execute();

        return array_map(function ($row) {
            return $row[0];
        }, $stmt->get_result()->fetch_all());
    }

    public function getSubredditPosts($subreddit) {
        $stmt = $this->dbConn->prepare('SELECT P.post_id, title, timestamp, author, subreddit, CONVERT(COALESCE(SUM(UPV.type), 0), UNSIGNED) AS upVotes, CONVERT(COALESCE(COUNT(UPV.type)-SUM(UPV.type), 0), UNSIGNED) AS downVotes FROM post P LEFT JOIN user_post_vote UPV ON P.post_id = UPV.post_id WHERE P.subreddit = ? GROUP BY P.post_id HAVING P.post_id IS NOT NULL');
        $stmt->bind_param('s', $subreddit);
        $stmt->execute();

        $result = $stmt->get_result();
        $rows = array();
        while($array = $result->fetch_assoc()){
            $rows[] = $array;
        }

        return $rows;
    }

    public function getSubredditPost($id) {
        $stmt = $this->dbConn->prepare('SELECT P.post_id, title, content, timestamp, author, subreddit, CONVERT(COALESCE(SUM(UPV.type), 0), UNSIGNED) AS upVotes, CONVERT(COALESCE(COUNT(UPV.type)-SUM(UPV.type), 0), UNSIGNED) AS downVotes FROM post P LEFT JOIN user_post_vote UPV ON P.post_id = UPV.post_id WHERE P.post_id = ? HAVING P.post_id IS NOT NULL');
        $stmt->bind_param('s', $id);
        $stmt->execute();

        $result = $stmt->get_result();

        return $result->fetch_assoc();
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
