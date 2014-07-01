<?php

if (isset($_SESSION['username'])) {
    echo '<span class="right bold">' . $_SESSION['username'] . ' [<a href="http://i.softuni-friends.org/logout" class="strong">logout</a>]</span> <a href="http://i.softuni-friends.org/post" title="Публикувай" class="button left">Публикувай</a>';
} else {
    echo '<a href="http://i.softuni-friends.org/login" class="button right" title="Вход в системата">Вход</a> <a href="http://i.softuni-friends.org/register" title="Регистрирай се!" class="button left">Регистрация</a>';
}