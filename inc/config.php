<?php

$db = mysqli_connect('localhost', 'isoftu9_ruth', 'parola123', 'isoftu9_ruth') or die
                ('<h1>Failed to connect to database!</h1>');
mysqli_query($db, 'SET NAMES utf8');

session_start();

$siteUrl = 'http://i.softuni-friends.org/';
$template = 'template/';
$includes = 'inc/';

include 'path.php';
include 'post.php';