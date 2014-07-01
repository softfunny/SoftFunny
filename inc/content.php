<section class="main-content">
    <article class="post">
        <header class="post-header">
            <h2>Публикация</h2>
            <p class="post-info">Published:
                <time datetime="<?= $row['date'] ?>"><?= $row['date'] ?></time> от <?= $row['username'] ?>
            </p>
        </header>
        <p><?= $row['content'] ?></p>
    </article>
</section>