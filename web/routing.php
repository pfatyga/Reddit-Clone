<?php

$filePath = __DIR__ . $_SERVER['REQUEST_URI'];
if ($_SERVER['REQUEST_URI'] == '/')
{
    print file_get_contents(__DIR__ . '/index.html');
    return;
}
if (file_exists($filePath))
{
    return false;
}
else if (substr($_SERVER['REQUEST_URI'], 0, 5) == '/api/')
{
    include __DIR__ . '/index.php';
    return;
}
else
{
    print file_get_contents(__DIR__ . '/index.html');
    return;
}