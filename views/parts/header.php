<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Manu Post</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@300&family=Newsreader:opsz,wght@6..72,300&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <nav>
        <p class="siteTitle">La Manu Post</p>
        <ul>
            <li><a href="/exo-pdo/accueil">Accueil</a></li>
            <li><a href="/exo-pdo/liste-des-articles">Tous les articles</a></li>
            <?php if (isset($_SESSION['user'])) { ?>
                <li><a href="/exo-pdo/ajouter-un-article">Ajouter un article</a></li>
                <li><a href="/exo-pdo/profil">Profil</a></li>
                <li><a href="/exo-pdo/modifier">Modifier Profil</a></li>
                <li><a href="/exo-pdo/supprimer">Suprimer Compte</a></li>
            <?php } ?>
        </ul>
        <ul>
            <?php if (!isset($_SESSION['user'])) { ?>
                <li><a href="/inscription">Inscription</a></li>
                <li><a href="/connexion">Connexion</a></li>
            <?php } else { ?>
                <li>Bonjour <?= $_SESSION['user']['username'] ?></li>
                <li><a href="/deconnexion">Déconnexion</a></li>
            <?php } ?>
        </ul>
    </nav>