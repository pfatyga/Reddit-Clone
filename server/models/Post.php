<?php

namespace reddit_clone\models;

/**
 * Class Post
 *
 * @package reddit_clone\models
 */
class Post
{
    use IdTrait;

    /**
    * @var string
    */
    private $title;

    /**
    * @var string
    */
    private $content;

    /**
    * @var string
    */
    private $author;

    /**
    * @var string
    */
    private $subreddit;

    /**
    * @var DateTime
    */
    private $when_created;

    /**
    * @var int
    */
    private $numComments;

    /**
    * @var int
    */
    private $numUpvotes;

    /**
    * @var int
    */
    private $numDownvotes;


}
