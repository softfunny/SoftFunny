<section class="main-content">
    <?php

    function selectTable($db, $table, $limit) {
        return mysqli_query($db, "SELECT e.id, e.title, e.content, e.time, u.username
				 FROM $table as e, users as u
				 WHERE e.author = u.id and e.id
				 ORDER BY e.time DESC LIMIT $limit;");
    }

    if ($page == 'index') {
        $limit = 3;
    } else {
        $categories = array($page);
        $limit = 10;
    }

    if (isset($_POST['p'])) {
        echo $_POST['p'];
    }

    $headings = array('Вицове и бисери', 'Смешни снимки', 'Смешни клипове');

    switch ($page) {
        case 'jokes': $headings = array($headings[0]);
            break;
        case 'pictures': $headings = array($headings[1]);
            break;
        case 'video': $headings = array($headings[2]);
            break;
    }

    function cutText($text, $length) {
        $article = strip_tags($text);

        if (strlen($article) > $length) {
            $articleCut = substr($article, 0, $length);
            $article = substr($articleCut, 0, strrpos($articleCut, ' ')) . '...';
        }

        return $article;
    }

    for ($i = 0; $i < count($categories); ++$i) {
        $cat = $categories[$i];

        $content = selectTable($db, $cat, $limit);

        echo '<header><h1>' . $headings[$i] . '</h1></header>';

        while ($row = mysqli_fetch_array($content)) {

            $link = "<a onclick='post($row[id])'>";
            $postInfo = '<p class="post-info">' . date('d.m.Y', $row['time']) . ' от ' . $row['username'] . '</p>';
            $post = $row['content'];

            $title = $link . cutText($row['title'], 30) . '</a>';
            $article = cutText($post, 130) . $link . 'още</a>';

            if ($cat == 'jokes') { // JOKES
                echo
                "<article class='post'>
                <header>
                    <h2>$title</a></h2>
                        $postInfo
                </header>
                <p>$article</p>
            </article>";
            } else if ($cat == 'pictures') { // PICTURES
                echo
                "<article class='post picture'>
                    <figure>
                        <h2>$title</h2>
                            $link<img src='$siteUrl" . "$post' alt='$title'></a>
                        <figcaption>$postInfo</figcaption>
                    </figure>
                </article>";
            } else if ($cat == 'video') { // VIDEOS
                echo
                "<article class='post video'>
                    <h2>$title</h2>
                    <iframe class='video' src='$post' allowfullscreen></iframe>
                        $postInfo
                </article>";
            }
        }
    }
    ?>
</form>
<footer>
    <p><a class="button" id="more" title="Още" onclick="post('<?= $page ?>', {p: 'm'})">ЗАРЕДИ ОЩЕ</a></p><br>
</footer>
</section>