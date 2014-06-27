<?php

if (isset($_SESSION['username'])) {
    echo '<span class="right strong bold">' . $_SESSION['username'] . ' [<a href="inc/logout.php" class="strong">logout</a>]</span> <a href="post" title="Публикувай" class="button left">Публикувай</a>';
} else {
    echo '<a href="login" class="button right" title="Вход в системата">Вход</a> <a href="register" title="Регистрирай се!" class="button left">Регистрация</a>';
}