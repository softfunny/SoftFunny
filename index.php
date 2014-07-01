<?php

include 'inc/config.php';

$url = new path('/');
$page = $url->segment(1) ? $url->segment(1) : 'index';
$isLogged = isset($_SESSION['username']);
$categories = array('jokes', 'pictures', 'video');

if ($page == 'logout') {
    session_start();
    session_destroy();
    $page = 'index';
    echo $returnToIndex;
}

if ($isLogged) {
    if ($page == 'login' || $page == 'register') {
        $notice['success'][] = 'Вие вече сте влезли в системата!';
        $page = 'index';
    }
} else {
    if ($page == 'post') {
        $notice['error'][] = 'Трябва да влезете за достъп до тази страница!';
        $page = 'index';
    }
}

include $template . 'header.html';
include $includes . 'users.php';
include $includes . 'messages.php';
    
if ($page === 'index' || in_array($page, $categories)) {
    include $includes . 'home.php';
}
else if(!include $template . $page . '.html') {
        include $template . '404.html';
}

include $template . 'aside.html';
include $template . 'footer.html';