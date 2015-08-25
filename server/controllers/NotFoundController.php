<?php

namespace reddit_clone\controllers;

/**
 * Class NotFoundController
 *
 * @package reddit_clone\controllers
 */
class NotFoundController
{
    public function getNotFound()
    {
        http_response_code(404);
        // @todo make 404 page
        return null;
    }
}
