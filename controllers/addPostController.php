<?php

/**
 * Je vérifie que mon utilisateur est connecté car je veux que uniquement les personnes connectées puissent écrire un article (lignes 9 à 14).
 * En me connectant, je crée une variable de session ($_SESSION['user']) qui contient toutes les informations que je veux pouvoir passer de page en page. 
 * Si cette variable n'existe pas, c'est que je ne suis pas passé ou que je n'ai pas réussi à me connecter.
 * Donc si $_SESSION['user'] , n'existe pas, je renvoie l'utilisateur sur la page de connexion grâce à la fonction header. L'action est (quasi) instantanée donc transparente.
 */
session_start();

if (!isset($_SESSION['user'])) {
    header('Location:/connexion');
    exit;
}
// Fin de la vérification de la connexion

// Je charge mes modèles pour pouvoir instancier mes objets ($var = new object) et utiliser mes méthodes
require_once '../models/postsModel.php';
require_once '../models/postsCategoriesModel.php';
require_once '../errors.php';

/**
 * Liste des catégories : partie 1 / 2
 * Pour ajouter mon article, je dois renseigner l'id de la catégorie à laquelle il appartient.
 * Mon utilisateur ne connait pas cet id, il n'a pas forcément accès à la base de données.
 * Pour renseigner cet id, je vais mettre à dispostion de l'utilisateur une liste affichant le nom des catégories (pour l'utilisateur) et qui renvoit l'id de la catégorie sélectionnée (pour la requête).
 * Pour ça, j'ai créé dans mon modèle une méthode qui liste toutes les catégories et leurs id.
 * J'appelle cette méthode et je la stocke dans une variable $pcList. 
 * Comme ma méthode me renvoie un tableau d'objet, $pcList est un tableau d'objets.
 * Suite dans postsModel.php
 */
$pc = new postsCategories;
$pcList = $pc->getList();

// Gestion du formulaire
// Je crée le tableau qui contiendra mes erreurs.
$formErrors = [];
/**
 * Je vérifie que le formulaire a été envoyé.
 * Pour ça je vérifie que mon $_POST contient quelque chose. Il se remplit automatiquement quand j'envoie un formulaire avec la méthode POST.
 */
if (count($_POST) > 0) {
    // J'instancie mon objet pour pouvoir le remplir si mes informations correspondent à mes vérifications.
    $post = new posts;

    /**
     * Pour une fois, pas beaucoup de vérifications. 
     * Mes articles pouvant contenir tout un tas de choses, je ne vois pas l'intérêt d'une regex. 
     * Par contre, je protège quand même ma base de données et mon site en utilisant la fonction strip_tags qui supprime les balises html du $_POST['title] et me protège donc le la faille XSS.
     * Plus d'infos sur la faille xss : https://www.vaadata.com/blog/fr/failles-xss-principes-types-dattaques-exploitations-et-bonnes-pratiques-securite/
     */
    if (!empty($_POST['title'])) {
        $post->title = strip_tags($_POST['title']);
    } else {
        $formErrors['title'] = ERROR_POSTS_TITLE_EMPTY;
    }

    if (!empty($_POST['content'])) {
        $post->content = strip_tags($_POST['content']);
    } else {
        $formErrors['content'] = ERROR_POSTS_CONTENT_EMPTY;
    }

    /**
     * Ajouter un fichier dans la base de données :
     * Il y a plusieurs manières d'ajouter des fichiers dans la base de données :
     * 1 - L'ajouter VRAIMENT à la base de données en utilisant un champs de type BLOB (peu avantageux dans notre cas car prend beaucoup de place et prennent plus de temps à charger)
     * 2 - Le déplacer dans le serveur et n'enregistrer que son chemin (moins de place et sans délai)
     * Nous allons utiliser la deuxième méthode, le BLOB étant plus pratique pour d'autres actions mais pas dans notre cas. (Plus d'infos sur le BLOB: https://www.ionos.fr/digitalguide/sites-internet/developpement-web/binary-large-object/) 
     * 
     * Pour rappel, les fichiers envoyés par un formulaire sont stockés dans une variable superglobale spécifique : $_FILES. 
     * Chaque fichier crée un tableau dans le $_FILES nommé avec le name de l'input. 
     * Ici notre input a pour name image, les informations de l'image seront stockées dans $_FILES['image']. 
     * Tous les tableaux créés auront la même strcture :
     *     [name] => le nom originel du fichier - celui qu'il a sur le pc d'origine (Exemple : MonFichier.png)
     *     [type] => Le type de fichier : attention, se base sur l'extension, peut être faussé (Exemple : image/png)
     *     [tmp_name] => Nom et emplacement temporaire du fichier. Votre fichier est stocké temporairement sur votre serveur en attendant le traitement que vous allez en faire. L'emplacement dépend de la configuration de votre serveur. (Exemple : /tmp/php/php1h4j1o) 
     *     [error] => Le code de l'erreur (Exemple : 0)
     *     [size] => Taille du fichier en octets (Exemple : 12000o)
     * 
     * Liste des codes d'erreur : https://www.php.net/manual/fr/features.file-upload.errors.php
     * 
     * Dans le cadre du projet, je n'ai pas besoin de gérer chaque erreur en particulier.
     */

    /**
     * Upload de fichier : partie 1/2
     * Je vérifie que mon fichier a bien été envoyé (voir lien sur les codes erreur)
     * Séparer cette erreur des autres me permet de créer un message d'erreur particulier pour cette erreur.
     */
      
    if ($_FILES['image']['error'] != 4) {
        /**
         * Je vérifie que mon image ne dépasse pas la limite que je fixe.
         * Vous pouvez choisir la limite à ne pas dépasser pour l'envoi (aussi appelé upload) de vos fichiers
         * Attention cependant : une limite est aussi fixée dans le fichier php.ini de votre version de php (Exemple pour moi : C:\laragon\bin\php\php-8.1.10-Win32-vs16-x64\php.ini)
         * Pensez à modifier les deux si vous devez gérer de gros fichiers.
         */
        if ($_FILES['image']['size'] < 1000000) {
            //Au final, si je n'ai pas d'autres erreurs...
            if ($_FILES['image']['error'] == 0) {
                /**
                 * ... je commence à vérifier si mon fichier correspond à ce que je veux ici une image.
                 * J'extraie les infos grâce à la fonction pathinfo pour récupérer l'extension.
                 * Il y a d'autres méthodes pour récupérer l'extension mais celle-ci ne cause pas d'erreur si un point est présent dans le nom du fichier.
                 * pathinfo est une fonction qui peut renvoyer plusieurs informations sur le chemin du fichier qu'on lui donne.
                 * Ici j'ai précisé PATHINFO_EXTENSION en second paramètre donc elle ne me renvoie que l'extension.
                 * 
                 * Je lui donne en paramètre le name fichier;.
                 */
                $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

                /**
                 * Je définis un tableau contenant les extensions autorisées associées à leurs types mimes
                 * Je passe par un tableau car j'autorise plusieurs extensions et ça va simplifier ma vérification un peu plus bas.
                 */
                $authorizedExtension = [
                    'jpg' => 'image/jpeg',
                    'jpeg' => 'image/jpeg',
                    'png' => 'image/png',
                    'gif' => 'image/gif'
                ];

                /**
                 * Le but de cette condition est de vérifier si le fichier a la bonne extension et qu'il bien ce qu'il dit être. Exemple : si j'upload un gif, je vérifie si l'extention est autorisée (ici oui) et que le type mime est bien celui d'une image gif.
                 * Les extensions autorisées étant les clés de mon tableau, j'utilise array_key_exists pour checker qu'elles existent bien dans le tableau.
                 * Puis je vérifie si le content type correspond à image ayant cette extension.
                 * Je lui donne en paramètre le chemin temporaire du fichier pour aller l'analyser.
                 */
                if (array_key_exists($extension, $authorizedExtension) && mime_content_type($_FILES['image']['tmp_name']) == $authorizedExtension[$extension]) {
                    /**
                     * Je définis le chemin où je vais déplacer l'image et le nom que je vais lui donner.
                     * medias : le dossier que j'ai créé pour accueillir mes fichiers uploadés
                     * uniqid : fonction permettant de créer un id unique (me permet de renommer mon fichier aléatoirement pour éviter d'écraser un autre fichier)
                     * date() : Ici, génère la date d'aujourd'hui en utilisant des tirets comme séparateur
                     * Attention : pour l'instant le fichier n'est pas enregistré. On va attendre de voir si on crée l'article sans erreur.
                     */
                    $path = 'medias/' . uniqid() . '_' . date('d-m-Y') . '.' . $extension;
                } else {
                    $formErrors['image'] = ERROR_POSTS_IMAGE_INVALID;
                }
            } else {
                $formErrors['image'] = ERROR_POSTS_IMAGE_UPLOAD;
            }
        } else {
            $formErrors['image'] = ERROR_POSTS_IMAGE_SIZE;
        }
    } else {
        $formErrors['image'] = ERROR_POSTS_IMAGE_EMPTY;
    }


    if (!empty($_POST['id_postsCategories'])) {
        $pc->id = $_POST['id_postsCategories'];
        // J'utilise une méthode pour vérifier que la catégorie existe parce que même si j'ai donné une liste déroulante à mon utilisateur pour éviter les mauvaises saisies, il peut corrompre cette liste.
        if ($pc->checkIfExists() == 1) {
            $post->id_postsCategories = $_POST['id_postsCategories'];
        } else {
            $formErrors['id_postsCategories'] =  ERROR_POSTS_CATEGORY_INVALID;
        }
    } else {
        $formErrors['id_postsCategories'] =  ERROR_POSTS_CATEGORY_EMPTY;
    }
    
    if (count($formErrors) == 0) {
        // Je donne l'id qui a été stocké lors de la connexion pour dire que c'est l'utilisateur connecté qui a crée l'article
        $post->id_users = $_SESSION['user']['id'];
        /**
         * Upload de fichiers : Partie 2/2
         * Si j'arrive à bouger mon fichier ou je le veux, j'ajoute l'article...
         */
        if (move_uploaded_file($_FILES['image']['tmp_name'], '../' . $path)) {
            $post->image = $path;
            // ... et si l'article n'arrive pas à se créer ...
            if($post->add()){
                $success = SUCCESS_POSTS_ADD;
            } else {
                $formErrors['general'] = ERROR_POSTS_GENERAL;
                // ... je supprime l'image.
                unlink('../' . $path);
            }
        } else {
            $formErrors['image'] = ERROR_POSTS_IMAGE_UPLOAD;
        }
    }
}



// Je charge mes vues à la toute fin car je traite les infos avant d'afficher.
require_once '../views/parts/header.php';
require_once '../views/addPost.php';
require_once '../views/parts/footer.php';
