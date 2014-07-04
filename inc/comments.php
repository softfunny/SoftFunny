<?php

$select_comments = mysqli_query($db, 'SELECT * FROM comments LEFT JOIN users
                                      ON comments.author_id = users.id
                                      WHERE post_id = ' . $row[id]);

while ($post = mysqli_fetch_assoc($select_comments)) {
    $date = date('d.m.Y, H:i:s', $post['date_added']);
    $post_id = $post[id];
    if ($post != 0) {
        echo '<section class="comment">
                <header>
                    <h2>' . $post['username'] . '</h2>
                    <p class="post-info comment-info">' . $date . '</p>
                </header>
                <p>' . $post['comment'] . '</p>
              </section>';
    } else {
        echo '<div class="formee-msg-info">Все още няма коментари!</div>';
    }
}

if ($isLogged) {
    echo "<form class='formee comments' method='post' onsubmit='return validate(this)'>
        <fieldset>
            <legend>Коментирай</legend>
            <div class='grid-9-12 clear' id='text-field'>
                <textarea name='content' id='content' placeholder='Коментар'></textarea>
            </div>
            <div class='grid-12-12 clear'>
                <input type='submit' name='$cat' id='post' value='Публикувай'>
                <input type='hidden' name='post_id' value='$row[id]'>
            </div>
        </fieldset>
        </form>";
}
 else {
    echo "<div class='formee-msg-info'>Моля <a href='$siteUrl/login'><strong>влезте в профила си</strong></a> за да коментирате!</div><br><br>";
}