<?php
session_start();

require_once '../models/postsModel.php';
require_once '../models/commentsModel.php';
require_once '../errors.php';

$formErrors = [];

//Instanciation de l'objet posts
$posts = new posts;
$comment = new comments;

//Je récupère l'id de l'article dans l'url et je le stocke dans l'attribut id de l'objet posts
$posts->id = $_GET['id'];

// ça me permet d'utiliser la méthode checkIfExists() et getOneById() qui me permettent de vérifier que l'article existe bien et de récupérer ses informations
if ($posts->checkIfExists() == 1) {
    $post = $posts->getOneById();
} else {
    // Si l'article n'existe pas, je redirige l'utilisateur vers la liste des articles
    header('Location:/liste-des-articles');
    exit;
}

$comment->id_posts = $posts->id;

/**
 * Compte le nombre d'éléments dans le tableau POST.
 * Si = 0, le formulaire n'est pas envoyé
 * Permet d'éviter que les vérifications se lancent au premier chargement de la page
 */
if (count($_POST) > 0) {
    //Instanciation de l'objet comments

    if (!empty($_POST['content'])) {
        $comment->content = $_POST['content'];
    } else {
        $formErrors['content'] = ERROR_COMMENTS_CONTENT_EMPTY;
    }

    $comment->id_users = $_SESSION['user']['id'];
    
    if(count($formErrors) == 0) {
        if($comment->add()) {
            $success = SUCCESS_COMMENTS_ADD;
        } else {
            $formErrors['general'] = ERROR_COMMENTS_GENERAL;
        }
    }
}

$commentsList = $comment->getListByPost();


require_once '../views/parts/header.php';
require_once '../views/readPost.php';
require_once '../views/addComment.php';
require_once '../views/commentsList.php';
require_once '../views/parts/footer.php';
