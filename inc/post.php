<?php

// LOGIN
if (isset($_POST['LOGIN'])) {
    $username = addslashes(trim($_POST['username']));
    $pass1 = addslashes(trim($_POST['pass1']));

// Validation
    if (empty($username) || empty($pass1)) {
        $notice['warning'][] = 'Username and password are required!';
    } else {
        $check = 'SELECT * FROM users WHERE username="' . $username . '" AND password="' . $pass1 . '"';
        $result = mysqli_query($db, $check);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['username'] = $username;
            $_SESSION['id'] = $row['id'];
            $_SESSION['level'] = $row['level'];
            echo '<meta http-equiv="refresh" content="0; url=index">';
        } else {
            $notice['error'][] = 'Wrong username or password!';
        }
    }
}

// REGISTER
if (isset($_POST['REGISTER'])) {
    $username = mysqli_real_escape_string($db, trim($_POST['username']));
    $pass1 = mysqli_real_escape_string($db, trim($_POST['pass1']));
    $pass2 = mysqli_real_escape_string($db, trim($_POST['pass2']));
    $email = mysqli_real_escape_string($db, trim($_POST['email']));

// Validation
    if (empty($username) || empty($pass1)) {
        $notice['warning'][] = 'Username and password are required.';
    }
    if (!empty($username) && !preg_match('/^\w{5,12}$/', $username)) {
        $notice['warning'][] = 'The username must contain only alphanumeric and be between 5 and 12 characters!';
    }
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $notice['error'][] = 'The email is not valid!';
    }
    if (!empty($pass1) && $pass1 == $pass2 && strlen($pass1) < 5) {
        $notice['error'][] = 'The password is too short!';
    }
    if ($pass1 != $pass2) {
        $notice['error'][] = 'The passwords does not match!';
    }

    if (!isset($notice)) {
// Check username and email
        $chek = 'SELECT username FROM users 
	         WHERE username="' . $username . '" OR email="' . $email . '"';
        $result = mysqli_query($db, $chek);

        if ($result->num_rows > 0) {
            $notice['error'][] = 'The username or the email is already in use!';
        }
    }

// Sign up the information
    if (!isset($notice)) {
        $ip = ip2long($_SERVER['REMOTE_ADDR']);
        $level = "1";
        if (!empty($email)) {
            $insert = 'INSERT INTO users (id, username, password, email, ip, level)
		   VALUES (NULL, "' . $username . '", "' . $pass1 . '", "' . $email . '", "' . $ip . '", "' . $level . '");';
        } else {
            $insert = 'INSERT INTO users (id, username, password, email, ip, level)
		   VALUES (NULL, "' . $username . '", "' . $pass1 . '", "' . $username . '", "' . $ip . '", "' . $level . '");';
        }
        if (mysqli_query($db, $insert)) {
            $_SESSION['username'] = $username;
            $_SESSION['id'] = mysqli_insert_id($db);
            $notice['success'][] = "You have successfully registered, $username!";
            echo '<meta http-equiv="refresh" content="0; url=index">';
        } else {
            $notice['error'][] = 'An error occured!';
        }
    }
}

// COMMENTS
if (isset($_POST['ADD_POST'])) {
    $comment = mysqli_real_escape_string($db, trim($_POST['comment']));

    if (empty($comment) || strlen($comment) < 4 || strlen($comment) > 250) {
        $notice['warning'][] = 'Your comment must be between 5 and 250 characters.';
    }
    if (!isset($notice)) {
// BB Code integrate
        $comment3 = $comment;
        $patterns = array(
            "/\[link\](.*?)\[\/link\]/",
            "/\[url\](.*?)\[\/url\]/",
            "/\[b\](.*?)\[\/b\]/",
            "/\[u\](.*?)\[\/u\]/",
            "/\[i\](.*?)\[\/i\]/"
        );
        $replacements = array(
            "<a href=\"\\1\">\\1</a>",
            "<a href=\"\\1\">\\1</a>",
            "<strong>\\1</strong>",
            "<u>\\1</u>",
            "<i>\\1</i>"
        );
        $comment = preg_replace($patterns, $replacements, $comment);
        $patterns4 = array(
            "/\[link\](.*?)\[\/link\]/",
            "/\[url\](.*?)\[\/url\]/",
            "/\[img\](.*?)\[\/img\]/",
            "/\[b\](.*?)\[\/b\]/",
            "/\[u\](.*?)\[\/u\]/",
            "/\[i\](.*?)\[\/i\]/"
        );
        $replacements4 = array(
            "",
            "",
            "",
            "",
            "",
            ""
        );
        $comment3 = preg_replace($patterns4, $replacements4, $comment3);

// Sign up the information
        $author_id = $_SESSION['id'];
        $post_id = (int) $_POST['post_id'];

        $insert = 'INSERT INTO comments (comment_id, post_id, comment, date_added, author_id)
                   VALUES (NULL, ' . $post_id . ', "' . $comment . '", ' . time() . ', ' . $author_id . ')';
        if (mysqli_query($db, $insert)) {
            $notice['success'][] = 'Thanks for the comment!';
            echo '<meta http-equiv="refresh" content="0">';
        } else {
            $notice['error'][] = 'An error occured!';
        }
    }
}