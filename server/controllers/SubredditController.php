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

    public function newPost(array $parameters) {
        $subreddit = $parameters['name'];
        $title = $_POST['title'];
        $content = $_POST['content'];
        $url = $_POST['url'];
        $imageUrl = $_POST['imageUrl'];
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
        $subreddit = array(
            'name' => $parameters['name'],
            'posts' => []
        );

        header('Content-Type: application/json');
        return json_encode($subreddit);
    }

    public function getSubredditPosts(array $parameters)
    {
        $subreddit_name = $parameters['name'];

        $posts = "[
          {
            \"post_id\": \"0\",
            \"title\": \"Check out this meme\",
            \"subreddit\": \"memes\",
            \"posted_by\": \"test_user\",
            \"when_created\": \"2015-07-22T10:00:00+00:00\",
            \"numComments\": 4,
            \"numUpvotes\": 1,
            \"numDownvotes\": 0
          }
        ]";

        header('Content-Type: application/json');
        return $posts;
    }

    public function getPost(array $parameters)
    {
        $post = "{
          \"post_id\": 4,
          \"title\": \"Check out this meme\",
          \"posted_by\": \"test_user\",
          \"subreddit\": \"memes\",
          \"when_created\": \"2015-07-22T10:00:00+00:00\",
          \"numComments\": 4,
          \"numUpvotes\": 1,
          \"numDownvotes\": 0,
          \"content\": \"This is nice meme. I really really really really like this meme.\",
          \"comments\": [
            {
              \"content\": \"Nice meme\",
              \"posted_by\": \"test_user\",
              \"when_created\": \"2015-07-22T10:00:00+00:00\",
              \"numUpvotes\": 1,
              \"numDownvotes\": 0,
              \"children\": [
                {
                  \"content\": \"Nice meme2\",
                  \"posted_by\": \"test_user\",
                  \"when_created\": \"2015-07-22T10:00:00+00:00\",
                  \"numUpvotes\": 1,
                  \"numDownvotes\": 0,
                  \"children\": [
                    {
                      \"content\": \"Nice meme4\",
                      \"posted_by\": \"test_user\",
                      \"when_created\": \"2015-07-22T10:00:00+00:00\",
                      \"numUpvotes\": 1,
                      \"numDownvotes\": 0,
                      \"children\": []
                    }
                  ]
                },
                {
                  \"content\": \"Nice meme3\",
                  \"posted_by\": \"test_user\",
                  \"when_created\": \"2015-07-22T10:00:00+00:00\",
                  \"numUpvotes\": 1,
                  \"numDownvotes\": 0,
                  \"children\": []
                }
              ]
            }
          ]
      }";

      header('Content-Type: application/json');
      return $post;

    }

}
