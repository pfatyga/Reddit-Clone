<?php

namespace reddit_clone\controllers;

/**
 * Class HomeController
 *
 * @package reddit_clone\controllers
 */
class HomeController
{
    /**
     * @return string
     */
    public function getHome()
    {
        global $config;

        $fastTemplate = new \FastTemplate('../' . $config['templatePath']);

        $fastTemplate->define(array(
            'main' => 'pages/home.html'
        ));

        $fastTemplate->parse('main', 'main');

        return $fastTemplate->fetch();
    }
}