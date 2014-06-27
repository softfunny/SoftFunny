<?php

$errorText = 'Възникна грешка! Моля опитайте отново.';
$returnToIndex = '<meta http-equiv="refresh" content="0; url=index">';
$usernameTaken = 'Потребителското име или Email-а са вече в употреба!';

// LOGIN
if (isset($_POST['LOGIN'])) {
    $username = escape($_POST['username']);
    $pass1 = escape($_POST['pass1']);

    $check = 'SELECT * FROM users WHERE username="' . $username . '" AND password="' . $pass1 . '"';
    $result = mysqli_query($db, $check);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['username'] = $username;
        $_SESSION['id'] = $row['id'];
        $_SESSION['level'] = $row['level'];
        echo $returnToIndex;
    } else {
        $notice['error'][] = 'Грешни входни данни!';
    }
}

// REGISTRATION
if (isset($_POST['REGISTER'])) {
    $username = escape($_POST['username']);
    $pass1 = escape($_POST['pass1']);
    $pass2 = escape($_POST['pass2']);
    $email = escape($_POST['email']);

// Check username and email
    $chek = 'SELECT username FROM users 
	         WHERE username="' . $username . '" OR email="' . $email . '"';
    $result = mysqli_query($db, $chek);

    if ($result->num_rows > 0) {
        $notice['error'][] = $usernameTaken;
    }

// Sign up the information
    if (!isset($notice)) {
        $ip = ip2long($_SERVER['REMOTE_ADDR']);
        $level = "1";

        $insert = 'INSERT INTO users (id, username, password, email, ip, level)
		   VALUES (NULL, "' . $username . '", "' . $pass1 . '", "' . $email || $username . '", "' . $ip . '", "' . $level . '");';

        if (mysqli_query($db, $insert)) {
            $_SESSION['username'] = $username;
            $_SESSION['id'] = mysqli_insert_id($db);
            $notice['success'][] = "Успешно се регистрирахте, $username!";
            echo $returnToIndex;
        } else {
            $notice['error'][] = $errorText;
        }
    }
}

// POST SYSTEM
if (isset($_POST['POST'])) {
    $category = escape($_POST['categoty']);

    // Publication
    $title = escape($_POST['title']);
    $content = escape($_POST['content']);

    // Picture
    $picTitle = escape($_POST['pic-title']);
    $picDesc = escape($_POST['pic-desc']);
    $source = escape($_POST['file']);

    // Video
    $vidTitle = escape($_POST['vid-title']);
    $vidDesc = escape($_POST['vid-desc']);
    $vidUrl = escape($_POST['url']);


    if ($category == 'joke') {
        // Sign up the information
        $insert = 'INSERT INTO entries (id, author, time, title, content)
                   VALUES (NULL,' . $_SESSION['id'] . ', ' . time() . ', "' . $title . '", "' . $content . '");'
                or die(mysqli_error());
        if (mysqli_query($db, $insert)) {
            $notice['success'][] = 'Благодарим за публикацията!';
            echo $returnToIndex;
        } else {
            $notice['error'][] = $errorText;
        }
    }
    if ($category == 'picture') {
        
    }
    if ($category == 'video') {
        
    }
}

function escape($post) {
    mysqli_real_escape_string($db, trim($post));
    return $post;
}