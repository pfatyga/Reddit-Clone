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

    public function getPost(array $parameters)
    {
        $post_id = $parameters['id'];
        $post = $this->subredditService->getSubredditPost($post_id);
        $post['comments'] = $this->subredditService->getPostComments($post_id);

        header('Content-Type: application/json');
        return json_encode($post);

    }

}
