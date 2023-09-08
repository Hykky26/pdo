<?php

session_start();

require_once '../models/usersModel.php';

    $drop = new users;
    $drop->id = $_SESSION['user']['id'];
    $drop->deleteUser();

      unset($_SESSION);
      session_destroy();
      header('Location:/exo-pdo/inscription');
      exit;

require_once '../views/parts/header.php';
require_once '../views/deleteInfo.php';
require_once '../views/parts/footer.php';
?>