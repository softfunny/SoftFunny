<?php

if (isset($_SESSION['username'])) {
    echo "<span class='right bold'>$_SESSION[username] [<a href='$siteUrl/logout' class='strong'>logout</a>]</span> <a href='$siteUrl/post' title='Публикувай' class='button left'>Публикувай</a>";
} else {
    echo "<a href='$siteUrl/login' class='button right' title='Вход в системата'>Вход</a> <a href='$siteUrl/register' title='Регистрирай се!' class='button left'>Регистрация</a>";
}