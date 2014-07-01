<?php

$select_comments = mysqli_query($db, 'SELECT * FROM comments LEFT JOIN users
                                      ON comments.author_id = users.id
                                      WHERE post_id = ' . $row[id]);

while ($post = mysqli_fetch_assoc($select_comments)) {
    $date = date('d.m.Y, H:i:s', $post['date_added']);
    if ($post != 0) {
        echo '<section class="comment">
                <header>
                    <h2>' . $post['username'] . '</h2>
                    <p class="post-info comment-info">' . $date . '</p>
                </header>
                <p>' . $post['comment'] . '</p>
              </section>';
    } else {
        echo '<div class="formee-msg-info">There is no comments at the moment!</div>';
    }
}

if ($isLogged) {
    echo "<form class='formee comments' method='post' action='/' onsubmit='return validate(this)'>
        <fieldset>
            <legend>Коментирай</legend>
            <div class='grid-9-12 clear' id='text-field'>
                <textarea name='content' id='content' placeholder='Публикация'></textarea>
            </div>
            <div class='grid-12-12 clear'>
                <input type='submit' name='$cat' id='post' value='Публикувай'>
                <input type='hidden' name='post_id' value='$row[id]'>
            </div>
        </fieldset>
        </form>";
}