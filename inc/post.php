<?php

// LOGIN
if (isset($_POST['LOGIN'])) {
    $username = addslashes(trim($_POST['username']));
    $pass1 = addslashes(trim($_POST['pass1']));

// Validation
    if (empty($username) || empty($pass1)) {
        $notice['warning'][] = 'Моля попълнете всички полета!';
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
            $notice['error'][] = 'Грешни входни данни!';
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
        $notice['warning'][] = 'Моля попълнете задължителните полета!';
    }
    if (!empty($username) && !preg_match('/^\w{5,12}$/', $username)) {
        $notice['warning'][] = 'Потребителското име може да съдържа само букви и цифри между 5 и 12 символа!';
    }
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $notice['error'][] = 'Моля въведете валиден Email адрес!';
    }
    if (!empty($pass1) && $pass1 == $pass2 && strlen($pass1) < 5) {
        $notice['error'][] = 'Паролата е твърде кратка!';
    }
    if ($pass1 != $pass2) {
        $notice['error'][] = 'Паролите не съвпадат!';
    }

    if (!isset($notice)) {
// Check username and email
        $chek = 'SELECT username FROM users 
	         WHERE username="' . $username . '" OR email="' . $email . '"';
        $result = mysqli_query($db, $chek);

        if ($result->num_rows > 0) {
            $notice['error'][] = 'Потребителското име или Email-а са заети!';
        }
    }

// Sign up the information
    if (!isset($notice)) {
        $ip = ip2long($_SERVER['REMOTE_ADDR']);
        $level = "1";

        $insert = 'INSERT INTO users (id, username, password, email, ip, level)
		   VALUES (NULL, "' . $username . '", "' . $pass1 . '", "' . $email . '", "' . $ip . '", "' . $level . '");';

        if (mysqli_query($db, $insert)) {
            $_SESSION['username'] = $username;
            $_SESSION['id'] = mysqli_insert_id($db);
            $notice['success'][] = "Успешно се регистрирахте, $username!";
            echo '<meta http-equiv="refresh" content="0; url=index">';
        } else {
            $notice['error'][] = 'Възникна грешка! Моля опитайте отново.';
        }
    }
}

// COMMENTS
if (isset($_POST['POST'])) {
    $title = htmlspecialchars(mysqli_real_escape_string($db, trim($_POST['title'])));
    $content = mysqli_real_escape_string($db, trim($_POST['content']));

    if (empty($title) || empty($content)) {
        $notice['info'][] = 'Моля попълнете всички полета.';
    }
    if (strlen($title) < 3 || strlen($title) > 50) {
        $notice['warning'][] = 'Заглавието трябва да е между 3 и 50 символа!';
    }
    if (strlen($content) < 20) {
        $notice['warning'][] = 'Публикацията трябва да е по-дълга от 20 символа!';
    }
    if (!isset($notice)) {

        // Sign up the information
        $insert = 'INSERT INTO entries (id, author, time, title, content)
                   VALUES (NULL,' . $_SESSION['id'] . ', ' . time() . ', "' . $title . '", "' . $content . '");'
                or die(mysqli_error());
        if (mysqli_query($db, $insert)) {
            $notice['success'][] = 'Благодарим за публикацията!';
            echo '<meta http-equiv="refresh" content="2; url=index">';
        } else {
            $notice['error'][] = 'Възникна грешка! Моля опитайте отново.';
        }
    }
}