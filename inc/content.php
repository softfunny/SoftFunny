<section class="main-content">
    <?php

    function selectTable($table, $index) {
        return 'SELECT e.id, e.title, e.content, e.time, u.username
				FROM ' . $table . ' as e, users as u
				WHERE e.author = u.id
				ORDER BY e.time DESC ' . $index . ';';
    }

    if ($page == 'index') {
        $index = 'LIMIT 3';
        $categories = array('jokes', 'pictures', 'video');
    } else {
        $categories = array($page);
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
        $content = mysqli_query($db, selectTable($categories[$i], $index));
        echo '<header><h1>' . $headings[$i] . '</h1></header>';

        while ($row = mysqli_fetch_array($content)) {
            $link = '<a href=' . $page . '/' . $row ['id'] . '> ';
            $postInfo = '<p class="post-info">' . date('d.m.Y', $row['time']) . ' от ' . $row['username'] . '</p>';
            $post = $row['content'];

            $article = cutText($post, 90) . $link . 'още...</а>';
            $title = $link . cutText($row['title'], 20) . '</a>';

            if ($categories[$i] == 'jokes') { // JOKES
                echo
                '<article class="post">
                <header>
                    <h2>' . $title . '</a></h2>
                    ' . $postInfo . '
                </header>
                <p>' . $article . '</a></p>
            </article>';
            } else if ($categories[$i] == 'pictures') { // PICTURES
                echo
                '<article class="post picture">
                    <figure>
                        <h2>' . $title . '</h2>
                       ' . $link . '<img src=  "' . $siteUrl . $post . '"  alt="' . $title . '"></a>
                        <figcaption>' . $postInfo . '</figcaption>
                    </figure>
                </article>';
            } else if ($categories[$i] == 'video') { // VIDEOS
                echo
                '<article class="post video">
                    <h2>' . $title . '</h2>
                    <iframe class="video" src= "' . $post . '" allowfullscreen></iframe>
                    ' . $postInfo . '
                </article>';
            }
        }
    }
    ?>
</section>