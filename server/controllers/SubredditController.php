<?php

namespace reddit_clone\controllers;

/**
 * Class SubredditController
 *
 * @package reddit_clone\controllers
 */
class SubredditController
{
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
}