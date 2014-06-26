<section class="jokes">
    <header>
        <h1>Популярни бисери</h1>
    </header>

    <?php
    while ($row = mysqli_fetch_array($content)) {
        $date = date('d.m.Y, H:i:s', $row['time']);

        echo
        '<article class="post"><header class="post-header">'
        . '<h2>' . $row['title'] . '</h2>
             <p class="post-info">' . $date . ' от ' . $row['username'] . '</p>
            </header>
            <p>' . $row['content'] . '</p></article>';
    }
    ?>

</section>