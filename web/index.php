<?php

include '../app/config.php';
include '../vendor/gabarro/class.FastTemplate.php';

$fastTemplate = new FastTemplate('../' . $config['templatePath']);

$fastTemplate->define(array(
    'main' => 'pages/home.html'
));

$fastTemplate->parse('main', 'main');

$fastTemplate->FastPrint();