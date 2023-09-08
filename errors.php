<?php

// GENERAL
define('ERROR_GENERAL', 'Le site est temporairement indisponible. Veuillez réessayer plus tard.');

//USERS
define('SUCCESS_USERS_ADD', 'L\'utilisateur a été ajouté avec succès');
define('ERROR_USERS_GENERAL', 'L\'utilisateur n\'a pas pu être créé. Veuillez réessayer plus tard.');
define('ERROR_USERS_LOGIN', 'L\'adresse mail ou le mot de passe est incorrect.');

//username
define('ERROR_USERS_USERNAME_EMPTY', 'Le nom d\'utilisateur est obligatoire.');
define('ERROR_USERS_USERNAME_INVALID', 'Le nom d\'utilisateur doit contenir au minimum 3 lettres et ne peut avoir que des lettres et chiffres.');
define('ERROR_USERS_USERNAME_ALREADY_EXISTS', 'Le nom d\'utilisateur existe déjà.');

//  Email
define('ERROR_USERS_EMAIL_EMPTY', 'L\'adresse mail est obligatoire.');
define('ERROR_USERS_EMAIL_INVALID', 'L\'adresse mail doit contenir un @, et un point.');
define('ERROR_USERS_EMAIL_ALREADY_EXISTS', 'L\'adresse mail existe déjà.');

// Mot de passe
define('ERROR_USERS_PASSWORD_EMPTY', 'Le mot de passe est obligatoire.');
define('ERROR_USERS_PASSWORD_INVALID', 'Le mot de passe doit contenir au minimum 8 caractères, 1 majuscule, 1 minuscule, un chiffre et un caractère spécial.');
define('ERROR_USERS_PASSWORD_DIFFERENT', 'Les mots de passe ne correspondent pas.');
define('ERROR_USERS_PASSWORD_CONFIRMATION_EMPTY', 'La confirmation du mot de passe est obligatoire.');

// Date de naissance
define('ERROR_USERS_BIRTHDATE_EMPTY', 'La date de naissance est obligatoire.');
define('ERROR_USERS_BIRTHDATE_INVALID', 'La date de naissance doit être au format JJ/MM/YYYY.');

// POSTS
define('SUCCESS_POSTS_ADD', 'L\'article a été ajouté avec succès');
define('ERROR_POSTS_GENERAL', 'L\'article n\'a pas pu être créé. Veuillez réessayer plus tard.');
// Titre
define('ERROR_POSTS_TITLE_EMPTY', 'Le titre est obligatoire.');

// Contenu
define('ERROR_POSTS_CONTENT_EMPTY', 'Le contenu est obligatoire.');

// Image
define('ERROR_POSTS_IMAGE_EMPTY', 'L\'image est obligatoire.');
define('ERROR_POSTS_IMAGE_SIZE', 'L\'image ne doit pas dépasser 1Mo.');
define('ERROR_POSTS_IMAGE_INVALID', 'L\'image doit être au format jpg, jpeg, png ou gif.');
define('ERROR_POSTS_IMAGE_UPLOAD', 'L\'image n\'a pas pu être envoyée.');

// Catégorie
define('ERROR_POSTS_CATEGORY_EMPTY', 'La catégorie est obligatoire.');
define('ERROR_POSTS_CATEGORY_INVALID', 'La catégorie est invalide.');

// COMMENTS
define('SUCCESS_COMMENTS_ADD', 'Le commentaire a été ajouté avec succès');
define('ERROR_COMMENTS_GENERAL', 'Le commentaire n\'a pas pu être créé. Veuillez réessayer plus tard.');
// Contenu
define('ERROR_COMMENTS_CONTENT_EMPTY', 'Le contenu est obligatoire.');