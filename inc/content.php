<section class="jokes">
    <?php
    if ($page == 'jokes') {
        $pageTitle = 'Вицове и бисери';
    } else if ($page == 'pictures') {
        $pageTitle = 'Забавни снимки';
    } else if ($page == 'video') {
        $pageTitle = 'Смешни клипове';
    } else {
        $pageTitle = 'Полулярни смешки';
    }
    ?>

    <header>
        <h1><?= $pageTitle ?></h1>
    </header>

    <?php
    
    echo $page;

    while ($row = mysqli_fetch_assoc($content)) {
        $date = date('d.m.Y, H:i:s', $row['time']);
        echo
        '<article class="post"><header class="post-header">
               <h2>' . $row['title'] . '</h2>
             <p class="post-info">' . $date . ' от ' . $row['username'] . '</p>
            </header>
            <p>' . $row['content'] . ' <a href=' . $page . '/' . $row['id'] . '>още...</a></p></article>';
    }


//         else if ($page == 'pictures') {
//            $date = date('d.m.Y, H:i:s', $row['time']);
//            echo
//            '<figure>'
//            . '<h2>' . $row['title'] . '</h2>
//            <img src=' . $row['source'] . ' alt=' . $row['title'] . '>'
//            . '<figcaption><p class="post-info">' . $date . ' от ' . $row['username'] . '</p></figcaption>';
//        } else if ($page == 'video') {
//            $date = date('d.m.Y, H:i:s', $row['time']);
//            echo
//            '<h2>' . $row['title'] . '</h2>
//               <iframe src= ' . $row['url'] . ' allowfullscreen></iframe>
//            <p class="post-info">' . $date . ' от ' . $row['username'] . '</p>';
//        } else if ($page == 'index' && $count == 3) {
//            break;
//        }
    ?>

</section>