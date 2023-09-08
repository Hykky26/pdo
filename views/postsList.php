<h1>Liste des articles</h1>
<main id="postsList">
    <?php foreach ($postsList as $pItem) { ?>
        <div class="articles">
            <div class="articleHeader">
                <p>Le <?= $pItem->publicationDate ?></p>
                <h2><?= $pItem->title ?></h2>
                <p><span class="<?= strtolower($pItem->category) ?>"><?= $pItem->category ?></span></p>
            </div>
            <img src="<?= $pItem->image ?>" alt="<?= $pItem->title ?>">
            <div class="articleContent">
                <p class="articlesInfos">Écrit par : <?= $pItem->username ?></p>
                <p><?= $pItem->content ?>...</p>
            </div>
            <div class="articleFooter">
                <a href="/article-<?= $pItem->id ?>" class="cta">Lire la suite</a>
            </div>
        </div>
    <?php } ?>
</main>