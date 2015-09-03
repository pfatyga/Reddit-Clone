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
        $sql = 'SELECT P.*, CONVERT(COALESCE(upVotes, 0), UNSIGNED) as upVotes, CONVERT(COALESCE(downVotes, 0), UNSIGNED) as downVotes, CONVERT(COALESCE(numComments, 0), UNSIGNED) as numComments
                FROM post P
                LEFT JOIN comment C
                ON P.post_id = C.post_id
                LEFT JOIN (
                    SELECT UPV.post_id, SUM(UPV.type) AS upVotes, COUNT(UPV.type)-SUM(UPV.type) AS downVotes
                	FROM user_post_vote UPV
                	GROUP BY UPV.post_id) votes
                ON P.post_id = votes.post_id
                LEFT JOIN (
                    SELECT C.post_id as post_id, COUNT(C.post_id) as numComments
                    FROM comment C
                    GROUP BY C.post_id) comments
                ON P.post_id = comments.post_id
                GROUP BY P.post_id
                HAVING P.post_id IS NOT NULL';

        $stmt = $this->dbConn->prepare($sql);
        $stmt->execute();

        $result = $stmt->get_result();
        $rows = array();
        while($array = $result->fetch_assoc()){
            $rows[] = $array;
        }

        usort($rows, function ($a, $b) {
            $aVotes = $a['upVotes'] - $a['downVotes'];
            $bVotes = $b['upVotes'] - $b['downVotes'];

            return $bVotes - $aVotes;
        });

        return $rows;

    }

    public function addModerator($subreddit, $username)
    {
        $sql = 'INSERT INTO user_subreddit_moderator (username, subreddit)
                VALUES (?, ?)';

        if($stmt = $this->dbConn->prepare($sql)) {
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

    public function addSubscriber($subreddit, $username)
    {
        $sql = 'INSERT INTO user_subreddit_subscription (username, subreddit)
                VALUES (?, ?)';

        if($stmt = $this->dbConn->prepare($sql)) {
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

    public function createSubreddit($subreddit)
    {
        $sql = 'INSERT INTO subreddit (name, timestamp)
                VALUES (?, ?)';

        if($stmt = $this->dbConn->prepare($sql)) {
            $datetime = date("Y-m-d H:i:s");
            if(!$stmt->bind_param('ss', $subreddit, $datetime)) {
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

    public function subredditExists($subreddit)
    {
        $sql = 'SELECT *
                FROM subreddit
                WHERE subreddit.name = ?';

        $stmt = $this->dbConn->prepare($sql);
        $stmt->bind_param('s', $subreddit);
        $stmt->execute();

        return $stmt->get_result()->num_rows > 0;
    }

    public function getCountSubredditSubscribers()
    {
        $sql = 'SELECT COUNT(*) AS count
                FROM `user_subreddit_subscription`
                WHERE subreddit = ?';

        $stmt = $this->dbConn->prepare($sql);
        $stmt->bind_param('s', $subreddit);
        $stmt->execute();

        return $stmt->get_result()->fetch_object()->count;
    }

    public function getSubredditModerators($subreddit)
    {
        $sql = 'SELECT username
                FROM user_subreddit_moderator
                WHERE subreddit = ?';

        $stmt = $this->dbConn->prepare($sql);
        $stmt->bind_param('s', $subreddit);
        $stmt->execute();

        return array_map(function ($row) {
            return $row[0];
        }, $stmt->get_result()->fetch_all());
    }

    public function getSubredditPosts($subreddit)
    {
        $sql = 'SELECT P.*, CONVERT(COALESCE(upVotes, 0), UNSIGNED) as upVotes, CONVERT(COALESCE(downVotes, 0), UNSIGNED) as downVotes, CONVERT(COALESCE(numComments, 0), UNSIGNED) as numComments
                FROM post P
                LEFT JOIN comment C
                ON P.post_id = C.post_id
                LEFT JOIN (
                    SELECT UPV.post_id, SUM(UPV.type) AS upVotes, COUNT(UPV.type)-SUM(UPV.type) AS downVotes
                	FROM user_post_vote UPV
                	GROUP BY UPV.post_id) votes
                ON P.post_id = votes.post_id
                LEFT JOIN (
                    SELECT C.post_id as post_id, COUNT(C.post_id) as numComments
                    FROM comment C
                    GROUP BY C.post_id) comments
                ON P.post_id = comments.post_id
                WHERE P.subreddit = ?
                GROUP BY P.post_id
                HAVING P.post_id IS NOT NULL';

        $stmt = $this->dbConn->prepare($sql);
        $stmt->bind_param('s', $subreddit);
        $stmt->execute();

        $result = $stmt->get_result();
        $rows = array();
        while($array = $result->fetch_assoc()){
            $rows[] = $array;
        }

        usort($rows, function ($a, $b) {
            $aVotes = $a['upVotes'] - $a['downVotes'];
            $bVotes = $b['upVotes'] - $b['downVotes'];

            return $bVotes - $aVotes;
        });

        return $rows;
    }

    public function getPostComments($id)
    {
        $sql = 'SELECT C.comment_id, timestamp, author, content, parent_comment_id, post_id, CONVERT(COALESCE(SUM(UCV.type), 0), UNSIGNED) AS upVotes, CONVERT(COALESCE(COUNT(UCV.type)-SUM(UCV.type), 0), UNSIGNED) AS downVotes
                FROM comment C
                LEFT JOIN user_comment_vote UCV
                ON C.comment_id = UCV.comment_id
                WHERE C.post_id = ?
                GROUP BY C.comment_id
                HAVING C.comment_id IS NOT NULL';

        $stmt = $this->dbConn->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();

        $result = $stmt->get_result();
        $rows = array();
        while($array = $result->fetch_assoc()){
            $rows[] = $array;
        }

        return $rows;
    }

    public function getPost($id)
    {
        $sql = 'SELECT P.*, CONVERT(COALESCE(upVotes, 0), UNSIGNED) as upVotes, CONVERT(COALESCE(downVotes, 0), UNSIGNED) as downVotes, CONVERT(COALESCE(numComments, 0), UNSIGNED) as numComments
                FROM post P
                LEFT JOIN comment C
                ON P.post_id = C.post_id
                LEFT JOIN (
                    SELECT UPV.post_id, SUM(UPV.type) AS upVotes, COUNT(UPV.type)-SUM(UPV.type) AS downVotes
                	FROM user_post_vote UPV
                	GROUP BY UPV.post_id) votes
                ON P.post_id = votes.post_id
                LEFT JOIN (
                    SELECT C.post_id as post_id, COUNT(C.post_id) as numComments
                    FROM comment C
                    GROUP BY C.post_id) comments
                ON P.post_id = comments.post_id
                WHERE P.post_id = ?
                GROUP BY P.post_id
                HAVING P.post_id IS NOT NULL';

        $stmt = $this->dbConn->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();

        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    public function getComment($id)
    {
        $sql = 'SELECT C.comment_id, timestamp, author, content, parent_comment_id, post_id, CONVERT(COALESCE(SUM(UCV.type), 0), UNSIGNED) AS upVotes, CONVERT(COALESCE(COUNT(UCV.type)-SUM(UCV.type), 0), UNSIGNED) AS downVotes
                FROM comment C
                LEFT JOIN user_comment_vote UCV
                ON C.comment_id = UCV.comment_id
                WHERE C.comment_id = ?
                GROUP BY C.comment_id
                HAVING C.comment_id IS NOT NULL';

        $stmt = $this->dbConn->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();

        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    public function newPost($subreddit, $title, $content, $url, $imageUrl, $user)
    {
        $sql = 'INSERT INTO post (subreddit, title, content, url, imageUrl, author, timestamp)
                VALUES (?, ?, ?, ?, ?, ?, ?)';

        if($stmt = $this->dbConn->prepare($sql)) {
            $datetime = date("Y-m-d H:i:s");
            if(!$stmt->bind_param('sssssss', $subreddit, $title, $content, $url, $imageUrl, $user, $datetime)) {
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

    public function newComment($subreddit, $post_id, $content, $user)
    {
        $sql = 'INSERT INTO comment (author, content, parent_comment_id, post_id, timestamp)
                VALUES (?, ?, NULL, ?, ?)';

        if($stmt = $this->dbConn->prepare($sql)) {
            $datetime = date("Y-m-d H:i:s");
            if(!$stmt->bind_param('ssss', $user, $content, $post_id, $datetime)) {
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

    public function newCommentReply($subreddit, $post_id, $parent_comment_id, $content, $user)
    {
        $sql = 'INSERT INTO comment (author, content, parent_comment_id, post_id, timestamp)
                VALUES (?, ?, ?, ?, ?)';

        if($stmt = $this->dbConn->prepare($sql)) {
            $datetime = date("Y-m-d H:i:s");
            if(!$stmt->bind_param('sssss', $user, $content, $parent_comment_id, $post_id, $datetime)) {
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

    public function upVotePost($post_id, $user)
    {
        $sql = 'INSERT INTO user_post_vote (username, post_id, type)
                VALUES (?, ?, 1)
                ON DUPLICATE KEY UPDATE type=1';

        if($stmt = $this->dbConn->prepare($sql)) {
            if(!$stmt->bind_param('si', $user, $post_id)) {
                return false;//"Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
            }
            if (!$stmt->execute()) {
                return false;//"Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            }

            return $this->getPost($post_id);
        } else {
            return false;//"Prepare statement failed";
        }
    }

    public function downVotePost($post_id, $user)
    {
        $sql = 'INSERT INTO user_post_vote (username, post_id, type)
                VALUES (?, ?, 0)
                ON DUPLICATE KEY UPDATE type=0';

        if($stmt = $this->dbConn->prepare($sql)) {
            if(!$stmt->bind_param('si', $user, $post_id)) {
                return false;//"Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
            }
            if (!$stmt->execute()) {
                return false;//"Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            }

            return $this->getPost($post_id);
        } else {
            return false;//"Prepare statement failed";
        }
    }

    public function upVoteComment($comment_id, $user)
    {
        $sql = 'INSERT INTO user_comment_vote (username, comment_id, type)
                VALUES (?, ?, 1)
                ON DUPLICATE KEY UPDATE type=1';

        if($stmt = $this->dbConn->prepare($sql)) {
            if(!$stmt->bind_param('si', $user, $comment_id)) {
                return false;//"Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
            }
            if (!$stmt->execute()) {
                return false;//"Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            }

            return $this->getComment($comment_id);
        } else {
            return false;//"Prepare statement failed";
        }
    }

    public function downVoteComment($comment_id, $user)
    {
        $sql = 'INSERT INTO user_comment_vote (username, comment_id, type)
                VALUES (?, ?, 0)
                ON DUPLICATE KEY UPDATE type=0';

        if($stmt = $this->dbConn->prepare($sql)) {
            if(!$stmt->bind_param('si', $user, $comment_id)) {
                return false;//"Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
            }
            if (!$stmt->execute()) {
                return false;//"Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            }

            return $this->getComment($comment_id);
        } else {
            return false;//"Prepare statement failed";
        }
    }

}
