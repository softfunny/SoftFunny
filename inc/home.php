<section class="main-content">
    <?php
    $headings = array('Вицове и бисери', 'Смешни снимки', 'Смешни клипове');

    switch ($page) {
        case 'index' : $limit = 3;
            break;
        case 'jokes':
            $headings = array($headings[0]);
            $categories = array($categories[0]);
            $limit = 50;
            break;
        case 'pictures':
            $headings = array($headings[1]);
            $categories = array($categories[1]);
            $limit = 20;
            break;
        case 'video':
            $limit = 10;
            $headings = array($headings[2]);
            $categories = array($categories[2]);
            break;
    }

    for ($i = 0; $i < count($categories); ++$i) {
        $cat = $categories[$i];

        if ($url->segment(2)) {
            $content = selectTable($db, $cat, 1, $page_id);
        }
        else {
             $content = selectTable($db, $cat, $limit);
        }

        echo '<header><h1>' . $headings[$i] . '</h1></header>';

        while ($row = mysqli_fetch_array($content)) {
            $cat_id = $row[id];
            $link = "<a href='$siteUrl"."$cat/$cat_id'>";
            $postInfo = '<p class="post-info"> от ' . $row['username'] . ' на ' . date('d.m.Y', $row['time']) . '</p>';
            $post = $row['content'];

            if ($url->segment(2)) {
                $title = '<h2>' . $link . $row['title'] . '</a></h2>';
                $article = $post;
            } else {
                echo "<article class='post $cat'>";
                $title = '<h2>' . $link . cutText($row['title'], 45) . '</a></h2>';
                $article = cutText($post, 130);
            }
            if ($cat == 'jokes') { // JOKES
                echo
                "<header>
                    $title
                        $postInfo
                </header>
                <p>$article</p>
            </article>";
            } else if ($cat == 'pictures') { // PICTURES
                echo
                "<figure>
                    $title
                        $link<img src='$siteUrl" . "$post' alt='$row[title]'></a>
                    <figcaption>$postInfo</figcaption>
                    </figure>
                </article>";
            } else if ($cat == 'video') { // VIDEOS
                echo
                "$title
                    <iframe class='video' src='$post' allowfullscreen></iframe>
                        $postInfo
                </article>";
            }
            if ($isLogged && $url->segment(2)) {
                include $includes . 'comments.php';
            }
            else if ($url->segment(2)) {
                echo '<br><div class="formee-msg-warning clear">Моля <strong><a href="http://i.softuni-friends.org/login">влезте</a></strong> в системата за да коментирате!</div>';
            }
        }
    }
    ?>
</section>