<?php

//Include confuguration files
include 'inc/config.php';

// Create instance of path class
$url = new path('/');

// Check if there is an uri segment / else return index
$page = $url->segment(1) ? $url->segment(1) : 'index';

include 'template/header.html';
include 'inc/messages.php';

// Check if the page exists
if (!include 'template/' . $page . '.html') {
    include 'template/404.html';
}

include 'template/aside.html';
include 'template/footer.html';