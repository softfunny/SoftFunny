<?php
echo '<aside class="user-panel">';

if (isset($_SESSION['username'])) {
    echo $_SESSION['username'] . ' [<a href="inc/logout.php">logout</a>]';
} else {
    echo 'Guest [<a href="login">login</a>]';
}

echo '</aside>';