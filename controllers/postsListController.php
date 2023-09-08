<?php
session_start();
require_once '../models/postsModel.php';

// J'instancie un nouvel objet posts
$posts = new posts();
// Je récupère la liste des articles
$postsList = $posts->getList();

require_once '../views/parts/header.php';
require_once '../views/postsList.php';
require_once '../views/parts/footer.php';