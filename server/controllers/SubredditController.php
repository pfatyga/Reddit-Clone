<?php

namespace reddit_clone\controllers;

use reddit_clone\services\SubredditService;

/**
 * Class SubredditController
 *
 * @package reddit_clone\controllers
 */
class SubredditController
{
    /**
     * @var \reddit_clone\services\SubredditService
     */
    private $subredditService;

    function __construct()
    {
        $this->subredditService = new SubredditService();
    }


    public function GetFrontPage() {
        $posts = $this->subredditService->getFrontPage();

        header('Content-Type: application/json');
        if($posts) {
            return json_encode($posts);
        } else {
            return null;
        }


    }

    public function createSubreddit(array $parameters) {
        session_start();
        if(isset($_SESSION['username'])) {
            $subreddit = $parameters['name'];
            $user = $_SESSION['username'];

            if(empty($subreddit)) {
                http_response_code(400);
                return "Missing data";
            }

            if($this->subredditService->createSubreddit($subreddit)) {
                $this->subredditService->addModerator($subreddit, $user);
                $this->subredditService->addSubscriber($subreddit, $user);
                http_response_code(200);
            } else {
                http_response_code(500);
                return "Something failed";
            }
        } else {
            http_response_code(401);
            return;
        }
    }

    public function newPost(array $parameters) {
        session_start();
        if(isset($_SESSION['username'])) {
            $subreddit = $parameters['name'];
            $title = $_POST['title'];
            $content = $_POST['content'];
            $url = $_POST['url'];
            $imageUrl = $_POST['imageUrl'];
            $user = $_SESSION['username'];

            if(empty($subreddit) || empty($title) || empty($content)) {
                http_response_code(400);
                return "Missing data";
            }

            $post_id = $this->subredditService->newPost($subreddit, $title, $content, $url, $imageUrl, $user);
            if($post_id) {
                http_response_code(200);
                return $post_id;
            } else {
                http_response_code(500);
                return "Something failed";
            }
        } else {
            http_response_code(401);
            return;
        }

    }

    public function newComment(array $parameters) {
        session_start();
        if(isset($_SESSION['username'])) {
            $subreddit = $parameters['name'];
            $post_id = $parameters['id'];
            $content = $_POST['content'];

            if(empty($subreddit) || empty($post_id) || empty($content)) {
                http_response_code(400);
                return "Missing data";
            }

            $comment_id = $this->subredditService->newComment($subreddit, $post_id, $content, $_SESSION['username']);
            if($comment_id) {
                http_response_code(200);
                return $comment_id;
            } else {
                http_response_code(500);
                return "Something failed";
            }
        } else {
            http_response_code(401);
            return;
        }

    }

    public function newCommentReply(array $parameters) {
        session_start();
        if(isset($_SESSION['username'])) {
            $subreddit = $parameters['name'];
            $post_id = $parameters['post_id'];
            $comment_id = $parameters['comment_id'];
            $content = $_POST['content'];

            if(empty($subreddit) || empty($post_id) || empty($content)) {
                http_response_code(400);
                return "Missing data";
            }

            $comment_id = $this->subredditService->newCommentReply($subreddit, $post_id, $comment_id, $content, $_SESSION['username']);
            if($comment_id) {
                $comment = $this->subredditService->getComment($comment_id);
                http_response_code(200);
                header('Content-Type: application/json');
                return json_encode($comment);
            } else {
                http_response_code(500);
                return "Something failed";
            }
        } else {
            http_response_code(401);
            return;
        }

    }

    public function upVotePost(array $parameters) {
        session_start();
        if(isset($_SESSION['username'])) {
            $subreddit = $parameters['name'];
            $post_id = $parameters['id'];

            if(empty($subreddit) || empty($post_id)) {
                http_response_code(400);
                return "Missing data";
            }

            $post = $this->subredditService->upVotePost($post_id, $_SESSION['username']);
            if($post) {
                http_response_code(200);
                header('Content-Type: application/json');
                return json_encode($post);
            } else {
                http_response_code(500);
                return "Something failed";
            }
        } else {
            http_response_code(401);
            return;
        }
    }

    public function downVotePost(array $parameters) {
        session_start();
        if(isset($_SESSION['username'])) {
            $subreddit = $parameters['name'];
            $post_id = $parameters['id'];

            if(empty($subreddit) || empty($post_id)) {
                http_response_code(400);
                return "Missing data";
            }

            $post = $this->subredditService->downVotePost($post_id, $_SESSION['username']);
            if($post) {
                http_response_code(200);
                header('Content-Type: application/json');
                return json_encode($post);
            } else {
                http_response_code(500);
                return "Something failed";
            }
        } else {
            http_response_code(401);
            return;
        }
    }

    public function upVoteComment(array $parameters) {
        session_start();
        if(isset($_SESSION['username'])) {
            $subreddit = $parameters['name'];
            $comment_id = $parameters['comment_id'];

            if(empty($subreddit) || empty($comment_id)) {
                http_response_code(400);
                return "Missing data";
            }

            $comment = $this->subredditService->upVoteComment($comment_id, $_SESSION['username']);
            if($comment) {
                http_response_code(200);
                header('Content-Type: application/json');
                return json_encode($comment);
            } else {
                http_response_code(500);
                return "Something failed";
            }
        } else {
            http_response_code(401);
            return;
        }
    }

    public function downVoteComment(array $parameters) {
        session_start();
        if(isset($_SESSION['username'])) {
            $subreddit = $parameters['name'];
            $comment_id = $parameters['comment_id'];

            if(empty($subreddit) || empty($comment_id)) {
                http_response_code(400);
                return "Missing data";
            }

            $comment = $this->subredditService->downVoteComment($comment_id, $_SESSION['username']);
            if($comment) {
                http_response_code(200);
                header('Content-Type: application/json');
                return json_encode($comment);
            } else {
                http_response_code(500);
                return "Something failed";
            }
        } else {
            http_response_code(401);
            return;
        }
    }


    /**
     * @return string
     */
    public function getSubreddits()
    {
        $subreddits = [];

        header('Content-Type: application/json');
        return json_encode($subreddits);
    }

    /**
     * @param array $parameters
     *
     * @return string
     */
    public function getSubreddit(array $parameters)
    {
        $name = $parameters['name'];
        if($this->subredditService->subredditExists($name)) {

            $posts = $this->subredditService->getSubredditPosts($name);
            $moderators = $this->subredditService->getSubredditModerators($name);
            $numSubscribers = $this->subredditService->getCountSubredditSubscribers($name);

            $subreddit = array(
                'name' => $name,
                'posts' => $posts,
                'moderators' => $moderators,
                'numSubscribers' => $numSubscribers
            );

            header('Content-Type: application/json');
            return json_encode($subreddit);
        } else {
            http_response_code(404);
            return;
        }

    }

    private function commentTreeInternal($comment, &$comments) {
        // echo "Running on ";
        // print_r($comment);
        // echo "\n";
        if(($key = array_search($comment, $comments)) !== false) {
            unset($comments[$key]);
        }

        $childComments = array();

        //get the comments that are children of $comment
        foreach ($comments as $c) {
            if(isset($c["parent_comment_id"]) && $c["parent_comment_id"] == $comment["comment_id"]) {
                $childComments[] = $c;
            }
        }

        // echo "Found children:\n";
        // print_r($childComments);

        //remove those children comments from the array
        foreach ($childComments as $childComment) {
            if(($key = array_search($childComment, $comments)) !== false) {
                unset($comments[$key]);
            }
        }

        //run this algorithm on those children recursively
        foreach ($childComments as $key => $childComment) {
            $childComments[$key] = $this->commentTreeInternal($childComment, $comments);
        }

        //set the children with their children attached as the children of this comment
        if(!empty($childComments)) {
            $comment["children"] = $childComments;
        }


        return $comment;

    }

    private function constructCommentTree($comments) {
        $done = array();
        while(!empty($comments)) {
            $done[] = $this->commentTreeInternal(array_values($comments)[0], $comments);
        }
        return $done;
    }


    public function getPost(array $parameters)
    {
        $post_id = $parameters['id'];
        $post = $this->subredditService->getPost($post_id);

        $post['comments'] = $this->constructCommentTree($this->subredditService->getPostComments($post_id));

        header('Content-Type: application/json');
        return json_encode($post);

    }

}
