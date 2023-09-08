<?php

/**
 * Ici je crée mon modèle sous forme de classe. Il va comprendre des attributs qui vont être comme des tiroirs dédiés, ils vont contenir la bonne information pour l'ajouter au bon endroit.
 */
class users {
    public $id;
    public $username;
    public $email;
    public $password;
    public $birthdate;
    public $registerDate;
    public $id_usersRoles;
    private $db;

    /**
     * Connecte à la base de données.
     * 
     * Cette méthode est magique, c'est-à-dire qu'elle se déclenche toute seule. On la reconnaît parce qu'elle est appelée précédée de 2 underscores (__)
     * Les noms des méthodes magiques sont prédéfinis. Ici construct se déclence au moment de l'instanciation de l'objet ($user = new users dans le contrôleur)
     */
    public function __construct() {
        try{
            $this->db = new PDO('mysql:host=localhost;dbname=la-manu-post;charset=utf8', 'pab7o_admin', 'MZb35g78uP6Ngs');
        } catch(PDOException $e) {
            //Renvoyer vers une page d'erreur
        }
    }

    /**
     * Ajoute un utilisateur (inscription)
     * @param string username Nom d'utilisateur
     * @param string email Adresse mail
     * @param string password Mot de passe (hashé)
     * @param string birthdate Date de naissance (au format mysql - yyyy-mm-dd)
     * @return bool Retourne true si la requête s'est exécutée ou false si la requête a rencontré un problème
     */
    public function add(){
        /**
         * Je définis la requête que je vais utiliser pour ajouter un utilisateur dans la table users
         * Je la crée et la teste dans phpMyAdmin pour être sûre qu'elle va fonctionner et que je n'aurais pas d'erreur au niveau du SQL
         * Je remplace les valeurs tests par des marqueurs nominatifs (:username). Pas besoin de le faire pour tout : ici par exemple je ne fais pas remplir ma date et mon rôle par l'utilisateur. Pour la date, je l'automatise grâce à la fonction NOW() et pour le rôle, je le définis à 1 directement dans la requête.
         * 
         * Si une requête ne contient pas toutes les informations nécessaires (requête dépendante d'un formulaire par exemple), elle sera lancée en plusieurs étapes : 
         * 1 : on la prépare (la base de données va analyser et optimiser la requête mais pas l'éxécuter)
         * 2 : on lui donne les informations manquantes 
         * 3 : on l'éxecute (ici l'utilisateur sera ajouté.)
         */
        
        $query = 'INSERT INTO `pab7o_users` (`username`, `email`,`password`, `birthdate`, `registerDate`, `id_usersRoles`) 
        VALUES (:username, :email, :password, :birthdate, NOW(), 1)';
        /**
         * Je prépare ma requête. Je lance prépare depuis $this->db, attribut dans lequel on a stocké l'objet pdo représentant la connexion à la base de données (Attention connexion à la base de données =/= connexion au site)
         * prepare est une méthode de l'objet pdo. On le reconnaît parce qu'elle est appelée par une flèche et a des parenthèses derrière. Elle renvoie un autre objet (PDOStatement) qui représente la requête.
         * Comme $request = $this->db->prepare($query), $request devient un objet PDOStatement
         */
        $request = $this->db->prepare($query);
        /**
         * On appelle la méthode bindValue qui permet de remplacer des marqueurs nominatifs dans une requête sql par des valeurs (celles venant du formulaire par exemple)
         * Elle prend 3 paramètres : 
         * * le nom du marqueur nominatif à remplacer (exemple : ':username')
         * * la valeur qui va la remplacer, ici $this->username donc le $user->username du contrôleur
         * * le format selon lequel la valeur va être traitée, ici username est traité comme une chaîne de caractère
         * 
         * La méthode bindValue est la plus efficace contre les injections SQL
         */
        $request->bindValue(':username', $this->username, PDO::PARAM_STR);
        $request->bindValue(':email', $this->email, PDO::PARAM_STR);
        $request->bindValue(':password', $this->password, PDO::PARAM_STR);
        $request->bindValue(':birthdate', $this->birthdate, PDO::PARAM_STR);
        /**
         * Enfin on exécute la requête, c'est uniquement à ce moment qu'elle fera l'action prévue (ici ajouter une ligne dans la table users)
         * 
         * La méthode execute renvie true ou false : true : la requête s'est exécutée sans erreur / false : un problème est survenu
         */
        return $request->execute();
    }

    /**
     * Vérifie si l'utilisateur existe déjà dans la base de données selon l'adresse mail
     * @param string email Email à vérifier
     * @return int Nombre de comptes contenant le mail
     */
    public function checkIfExistsByEmail() {
        $query = 'SELECT COUNT(*) FROM `pab7o_users` WHERE email = :email';
        $request = $this->db->prepare($query);
        $request->bindValue(':email', $this->email, PDO::PARAM_STR);
        $request->execute();
        return $request->fetch(PDO::FETCH_COLUMN);
    }


    /**
     * Récupère le mot de passe hashé dans la base de données (connexion)
     * @param string email Email de l'utilisateur souhaitant se connecter
     * @return int Nombre de comptes contenant le mail
     */
    public function getHash(){
        $query = 'SELECT `password` FROM `pab7o_users` WHERE `email` = :email;';
        $request = $this->db->prepare($query);
        $request->bindValue(':email', $this->email, PDO::PARAM_STR);
        $request->execute();
        return $request->fetch(PDO::FETCH_COLUMN);
    }

    /**
     * Récupère les informations de l'utilisateur après la connexion pour stocker dans la superglobal $_SESSION (informations nécessitant d'être emmenées dans toute l'application - pas de mot de passe, mail ou information sensible)
     * @param string email Adresse mail parce que la connexion se fait par mail dans ce projet
     */
    public function getInfos(){
        $query = 'SELECT `id`, `username`, `id_usersRoles` FROM `pab7o_users` WHERE `email` = :email';
        $request = $this->db->prepare($query);
        $request->bindValue(':email', $this->email, PDO::PARAM_STR);
        $request->execute();
        return $request->fetch(PDO::FETCH_ASSOC);
    }

    public function modifyUser() {
        $query = 'UPDATE pab7o_users 
        SET username = :username, email = :email, password = :password
        WHERE id = :id';

        $request = $this->db->prepare($query);
        $request->bindValue(':username', $this->username, PDO::PARAM_STR);
        $request->bindValue(':email', $this->email, PDO::PARAM_STR);
        $request->bindValue(':password', $this->password, PDO::PARAM_STR);
        $request->bindValue(':id', $this->id, PDO::PARAM_INT);
        return $request->execute();
    }

    public function deleteUser() {
        $query = 'DELETE FROM `pab7o_users` WHERE `id` = :id';
        $request = $this->db->prepare($query);
        $request->bindValue(':id', $this->id, PDO::PARAM_INT);
        return $request->execute();
    }

} 