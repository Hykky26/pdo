<?php
session_start();
require_once '../models/postsModel.php';
require_once '../models/commentsModel.php';
require_once '../errors.php';
//var_dump($_POST);

$posts = new posts();
$postsUsers = $posts->getUsersPosts();

require_once '../views/parts/header.php';
require_once '../views/profil.php';
require_once '../views/parts/footer.php';


