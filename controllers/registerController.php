<?php
session_start();
// if (!isset($_SESSION['user'])) {
//     header('Location:/connexion');
//     exit;
// }
require_once '../models/usersModel.php';
require_once '../errors.php';
//var_dump($_POST);

$regex = [
    'username' => '/^(?=.*[a-zA-Z]{3,})[a-zA-Z0-9-]+$/',
    'password' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
    'birthdate' => '/^[0-9]{4}(-[0-9]{2}){2}$/',
];

$formErrors = [];

if (count($_POST) > 0) {
    $user = new users;
    if (!empty($_POST['username'])) {
        if (preg_match($regex['username'], $_POST['username'])) {
            $user->username = strip_tags($_POST['username']);
        } else {
            $formErrors['username'] = 'Votre nom d\'utilisateur n\'est pas valide. Il doit comporter au moins 3 lettres et ne peut contenit que des lettres, chiffres et tirets.';
        }
    } else {
        $formErrors['username'] = ERROR_USERS_USERNAME_EMPTY;
    }

    if (!empty($_POST['email'])) {
        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $user->email = strip_tags($_POST['email']);
            try {
                if ($user->checkIfExistsByEmail() == 1) {
                    $formErrors['email'] = ERROR_USERS_EMAIL_ALREADY_EXISTS;
                }
            } catch (PDOException $e) {
                $formErrors['general'] = ERROR_GENERAL;
            }
        } else {
            $formErrors['email'] = ERROR_USERS_EMAIL_INVALID;
        }
    } else {
        $formErrors['email'] = ERROR_USERS_EMAIL_EMPTY;
    }

    if (!empty($_POST['password'])) {
        if (!preg_match($regex['password'], $_POST['password'])) {
            $formErrors['password'] = 'Votre mot de passe n\'est pas valide. Il doit comporter au moins 8 caractères dont une majuscule, une minuscule, un chiffre et un caractère spécial.';
        }
    } else {
        $formErrors['password'] = 'Veuillez renseigner votre mot de passe.';
    }

    if (!empty($_POST['passwordConfirm'])) {
        if (!isset($formErrors['password'])) {
            if ($_POST['password'] == $_POST['passwordConfirm']) {
                $user->password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            } else {
                $formErrors['password'] = $formErrors['passwordConfirm'] = 'Les mots de passes ne correspondent pas.';
            }
        }
    } else {
        $formErrors['passwordConfirm'] = 'Veuillez confirmer votre mot de passe.';
    }

    if (!empty($_POST['birthdate'])) {
        if (preg_match($regex['birthdate'], $_POST['birthdate'])) {
            $date = explode('-', $_POST['birthdate']);
            if (checkdate($date[1], $date[2], $date[0])) {
                $user->birthdate = $_POST['birthdate'];
            } else {
                $formErrors['birthdate'] = 'Votre date de naissance n\'est pas valide. Elle doit être au format jj/mm/aaaa.';
            }
        } else {
            $formErrors['birthdate'] = 'Votre date de naissance n\'est pas valide. Elle doit être au format jj/mm/aaaa.';
        }
    } else {
        $formErrors['birthdate'] = 'Veuillez renseigner votre date de naissance.';
    }

    if (count($formErrors) == 0) {
        try {
            if($user->add()) {
                $success = true;
            }
        } catch (PDOException $e) {
            $formErrors['general'] = 'Une erreur est survenue, l\'administrateur a été prévenu';
        }
    }
}

require_once '../views/parts/header.php';
require_once '../views/register.php';
require_once '../views/parts/footer.php';
