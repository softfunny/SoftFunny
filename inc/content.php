<section class="main-content">
    <header>
        <h1><?= $page ?></h1>
    </header>

    <?php
    $select = 'SELECT e.id, e.title, e.content, e.time, u.username
				FROM ' . $page . ' as e, users as u
				WHERE e.author = u.id
				ORDER BY e.time DESC';

    $content = mysqli_query($db, $select);

    while ($row = mysqli_fetch_assoc($content)) {
        $date = date('d.m.Y, H:i:s', $row['time']);
        $link = '<a href=' . $page . '/' . $row['id'] . '>';
        $title = $row['title'];
        $titleLink = $link . $title . '</a>';
        $post = $row['content'];
        $user = $row['username'];

        if ($page == 'index') {
            echo '<h2>Comming soon</h2>';
        } else if ($page == 'jokes') { // JOKES
            echo
            '<article class="post">
                <header class="post-header">
                    <h2>' . $titleLink . '</a></h2>
                    <p class="post-info">' . $date . ' от ' . $user . '</p>
                </header>
                <p>' . $post . $link . 'още...</a></p>
            </article>';
        } else if ($page == 'pictures') { // PICTURES
            echo
            '<figure>
            <h2>' . $titleLink . '</h2>
            <img src=  "' . $siteUrl . $post . '"  alt="' . $title . '">
        <figcaption><p class="post-info">' . $date . ' от ' . $user . '</p></figcaption>';
        } else if ($page == 'video') { // VIDEOS
            echo
            '<h2>' . $titleLink . '</h2>
            <iframe src= "' . $post . '" allowfullscreen></iframe>
            <p class="post-info">' . $date . ' от ' . $user . '</p>';
        }
    }
    ?>
</section>