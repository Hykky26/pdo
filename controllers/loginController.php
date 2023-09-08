<?php
session_start();
require_once '../models/usersModel.php';
require_once '../errors.php';

$formErrors = [];
if(count($_POST) > 0) {
    $user = new users();

    /**
     * Je récupère les informations nécessaires pour la connexion : email et mot de passe
     * Pour l'email, je vérifie qu'il est bien rempli (!empty) et qu'il est au bon format (filter_var)
     */
    if(!empty($_POST['email'])) {
        if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $user->email = $_POST['email'];
            // Je vérifie que l'utilisateur existe bien en base de données en comptant le nombre d'utilisateurs ayant cet email
            if($user->checkIfExistsByEmail() == 0){
                // Si l'utilisateur n'existe pas, je crée un message d'erreur
                $formErrors['email'] = $formErrors['password'] = ERROR_USERS_LOGIN;
            }
        } else {
            $formErrors['email'] = ERROR_USERS_EMAIL_INVALID;
        }
    } else {
        $formErrors['email'] = ERROR_USERS_EMAIL_EMPTY;
    }

    if(!empty($_POST['password'])) {
        // Si l'email est valide, je récupère le mot de passe hashé (chiffré) de l'utilisateur
        if(!isset($formErrors['email'])) {
            $user->password = $user->getHash();
            /**
             * Je vérifie que le mot de passe saisi correspond bien au mot de passe hashé grâce à la fonction password_verify
             * Je ne peux pas comparer les mots de passe en clair car le mot de passe saisi est en clair et le mot de passe en base de données est hashé
             */
            if(password_verify($_POST['password'], $user->password)){
                // Si le mot de passe est bon, je récupère les informations de l'utilisateur et je les stocke dans la session pour pouvoir les passer d'une page à l'autre
                $_SESSION['user'] = $user->getInfos();
                // Je redirige l'utilisateur vers la liste des articles
                header('Location:/liste-des-articles');
                // Je stoppe l'exécution du php pour éviter que le reste du code ne s'exécute
                exit;
            } else {
                $formErrors['email'] = $formErrors['password'] = ERROR_USERS_LOGIN;
            }
        }
    } else {
        $formErrors['password'] = ERROR_USERS_PASSWORD_EMPTY;
    }

}

require_once '../views/parts/header.php';
require_once '../views/login.php';
require_once '../views/parts/footer.php';

