<?php

include 'inc/config.php';

$url = new path('/');
$page = $url->segment(1) ? $url->segment(1) : 'index';
$page_id = str_replace('/', '', $url->segment(2));

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
} else if ($page == 'post') {
    $notice['error'][] = 'Трябва да влезете за достъп до тази страница!';
    $page = 'index';
}

require $template . 'header.html';
require $includes . 'users.php';
require $includes . 'messages.php';

if ($page === 'index' || $page == 'i' || in_array($page, $categories)) {
    require $includes . 'home.php';
} else if (!include $template . $page . '.html') {
    include $template . '404.html';
}

require $template . 'aside.html';
require $template . 'footer.html';
