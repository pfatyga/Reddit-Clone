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
     * @param array $parameters
     *
     * @return mixed
     */
    public function getSubreddit(array $parameters)
    {
        return $parameters['subreddit'];
    }
}