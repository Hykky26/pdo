<main>
    <?php foreach ($postsUsers as $u) { ?>
    <h2><?= $u->title ?></h2>
    <img src="<?= $u->image ?>" alt="<?= $u->title ?>">
    <p> Publié le : <?= $u->publicationDate ?> 
    <p><?= $u->content ?></p>
    <?php } ?>
</main>