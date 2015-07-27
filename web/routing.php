<?php

$requestUri = __DIR__ . $_SERVER['REQUEST_URI'];
if (file_exists($requestUri))
{
    return false;
}
else
{
    include __DIR__ . '/index.php';
}