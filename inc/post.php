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

        $email = $email ? $email : $username;

        $insert = 'INSERT INTO users (id, username, password, email, ip, level)
		   VALUES (NULL, "' . $username . '", "' . md5($pass1) . '", "' . $email . '", "' . $ip . '", "' . $level . '");';

        if (mysqli_query($db, $insert)) {
            $_SESSION['username'] = $username;
            $_SESSION['id'] = mysqli_insert_id($db);
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

    // Video
    $vidTitle = escape($_POST['vid-title']);
    $url = str_replace('watch?v=', 'embed/', escape($_POST['url']));

    // Sign up the information
    if ($category == 'pictures') {
        $title = $picTitle;
        $content = checkUpload();
    } else if ($category == 'video') {
        $title = $vidTitle;
        $content = $url;
    }

    $insert = 'INSERT INTO ' . $category . ' (id, author, time, title, content)
                   VALUES (NULL,' . $_SESSION['id'] . ', ' . time() . ', "' . $title . '", "' . $content . '");'
            or die(mysqli_error());
    if (mysqli_query($db, $insert)) {
        $notice['success'][] = 'Благодарим за публикацията!';
        echo $returnToIndex;
    } else {
        $notice['error'][] = $errorText;
    }
}

function escape($post) {
    mysqli_real_escape_string($db, trim($post));
    return $post;
}

// UPLOAD
function checkUpload() {
    $path = 'uploads' . DIRECTORY_SEPARATOR . 'pictures' . DIRECTORY_SEPARATOR;
    $max_upload_size = 2000000;
    $allowedTypes = array('image/pjpeg', 'image/jpeg', 'image/jpg', 'image/x-png', 'image/png', 'image/gif');
    
    if (isset($_FILES['file'])) {
        if (is_uploaded_file($_FILES['file']['tmp_name'])) {

            // Validation
            if ($_FILES['file']['size'] > $max_upload_size) {
                $notice['warning'][] = 'The file is too big!';
            }
            if (in_array($_FILES['file']['type'], $allowedTypes)) {
                $notice['error'][] = '<strong>Wrong file type!</strong><br />
			<strong>Allowed Types:</strong> txt, png, jpe, jpeg, jpg, gif, bmp';
            }
            if (file_exists($path . $_FILES['file']['name'])) {
                $notice['warning'][] = 'The file already exist!';
            }

            // TODO: Validate!
            if (!isset($notice)) {
                if (move_uploaded_file($_FILES['file']['tmp_name'], $path . $_FILES['file']['name'])) {
                    $notice['success'][] = 'The file '
                            . $_FILES['upload']['name'] . ' is successfully uploaded!';
                } else {
                    $notice['error'][] = 'The file '
                            . $_FILES['file']['name'] . ' is NOT uploaded!';
                }
            }

            // Delete the file if it still exists
            if (file_exists($_FILES['file']['tmp_name']) && is_file($_FILES['file']['tmp_name'])) {
                unlink($_FILES['file']['tmp_name']);
            }
        }

        return $path . $_FILES['file']['name'];
    }
}