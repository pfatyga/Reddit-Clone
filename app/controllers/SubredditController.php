<?php

namespace reddit_clone\controllers;

/**
 * Class SubredditController
 *
 * @package reddit_clone\controllers
 */
class SubredditController
{
    public function getSubreddit(array $parameters)
    {
        print $parameters['subreddit'];
    }
}