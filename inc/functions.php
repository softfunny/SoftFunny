<?php

function cutText($text, $length) {
    $article = strip_tags($text);

    if (strlen($article) > $length) {
        $articleCut = substr($article, 0, $length);
        $article = substr($articleCut, 0, strrpos($articleCut, ' ')) . '...';
    }

    return $article;
}

function escape(&$post) {
    mysqli_real_escape_string(trim($post), $db);
    return $post;
}

function checkUpload() {
    $path = 'uploads' . DIRECTORY_SEPARATOR . 'pictures' . DIRECTORY_SEPARATOR;
    $max_upload_size = 2000000;

    if (isset($_FILES['file'])) {
        if (is_uploaded_file($_FILES['file']['tmp_name'])) {

            // Validation
            if ($_FILES['file']['size'] > $max_upload_size) {
                $notice['warning'][] = 'The file is too big!';
            }
            if (file_exists($path . $_FILES['file']['name'])) {
                $notice['warning'][] = 'The file already exist!';
            }
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

function selectTable($db, $table, $count, $id) {
    if (isset($id)) {
        $select = " AND e.id = $id";
    }
    if (isset($count)) {
        $limit = " LIMIT $count;";
    }

    return mysqli_query($db, "SELECT e.id, e.title, e.content, e.time, u.username
				 FROM $table as e, users as u
				 WHERE e.author = u.id $select
				 ORDER BY e.time DESC $limit;");
}