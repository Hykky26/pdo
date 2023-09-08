<main>
    <?php foreach($commentsList as $c) { ?>
        <div>
            <p><?= $c->username ?> le <?= $c->publicationDate ?></p>
            <p><?= $c->content ?></p>
        </div>
        <?php } ?>
</main>