<main>
    <h2><?= $post->title ?></h2>
    <p><?= $post->category ?></p>
    <img src="<?= $post->image ?>" alt="<?= $post->title ?>">
    <p>Écrit par : <?= $post->username ?> - Publié le : <?= $post->publicationDate ?> - Mis à jour le : <?= $post->updateDate ?></p>
    <p><?= $post->content ?></p>
</main>