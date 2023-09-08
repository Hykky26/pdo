<?php
class posts
{
    public $id;
    public $title;
    public $content;
    public $publicationDate;
    public $updateDate;
    public $image;
    public $id_users;
    public $id_postsCategories;
    private $db;

    public function __construct()
    {
        try {
            $this->db = new PDO('mysql:host=localhost;dbname=la-manu-post;charset=utf8', 'pab7o_admin', 'MZb35g78uP6Ngs');
        } catch (PDOException $e) {
            //Renvoyer vers une page d'erreur
        }
    }

    /**
     * Ajoute un article dans la base de données
     * @param string title Le titre
     * @param string content Le contenu
     * @param string image Le lien de l'image depuis le dossier medias
     * @param int id_users L'id de la personne ayant posté l'article
     * @param int id_postsCategories L'id de la catégorie de l'article
     * @return bool
     */
    public function add()
    {
        $query = 'INSERT INTO `pab7o_posts`(`title`, `content`, `publicationDate`, `updateDate`, `image`, `id_users`, `id_postsCategories`) 
        VALUES (:title,:content,NOW(),NOW(),:image,:id_users,:id_postsCategories)';
        $request = $this->db->prepare($query);
        $request->bindValue(':title', $this->title, PDO::PARAM_STR);
        $request->bindValue(':content', $this->content, PDO::PARAM_STR);
        $request->bindValue(':image', $this->image, PDO::PARAM_STR);
        $request->bindValue(':id_users', $this->id_users, PDO::PARAM_INT);
        $request->bindValue(':id_postsCategories', $this->id_postsCategories, PDO::PARAM_INT);
        return $request->execute();
    }

    /**
     * Vérifie que l'article existe dans la base de données
     * @param int id id de l'article à vérifier
     * @return int nombre d'articles existant avec cet id
     */
    public function checkIfExists()
    {
        $query = 'SELECT COUNT(*) FROM `pab7o_posts` WHERE id = :id;';
        $request = $this->db->prepare($query);
        $request->bindValue(':id', $this->id, PDO::PARAM_INT);
        $request->execute();
        return $request->fetch(PDO::FETCH_COLUMN);
    }

    /**
     * Liste tous les articles sans conditions
     * @return arrayOfObjects Retourne un tableau d'objet
     */
    public function getList()
    {
        $query = 'SELECT `p`.`id`,`title`, `image`,SUBSTR(`content`, 1, 100) AS `content`,DATE_FORMAT(`publicationDate`, "%d/%m/%Y %Hh%i") AS `publicationDate`,DATE_FORMAT(`updateDate`, "%d/%m/%Y %Hh%i") AS `updateDate`,`username`,`name` AS `category` FROM `pab7o_posts` AS `p` INNER JOIN `pab7o_users` AS `u` ON `id_users` = `u`.`id` INNER JOIN `pab7o_postscategories` AS `pc` ON `id_postsCategories` = `pc`.`id`;';
        $request = $this->db->query($query);
        return $request->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Récupère un article selon son id
     * @param int id L'id de l'article à récupérer
     * @return object 
     */
    public function getOneById()
    {
        $query = 'SELECT `title`, `image`,`content`,DATE_FORMAT(`publicationDate`, "%d/%m/%Y %Hh%i") AS `publicationDate`,DATE_FORMAT(`updateDate`, "%d/%m/%Y %Hh%i") AS `updateDate`,`username`,`name` AS `category` FROM `pab7o_posts` AS `p` INNER JOIN `pab7o_users` AS `u` ON `id_users` = `u`.`id` INNER JOIN `pab7o_postscategories` AS `pc` ON `id_postsCategories` = `pc`.`id` WHERE `p`.`id` = :id;';
        $request = $this->db->prepare($query);
        $request->bindValue(':id', $this->id, PDO::PARAM_INT);
        $request->execute();
        return $request->fetch(PDO::FETCH_OBJ);
    }

    public function getUsersPosts() {
        $query = 'SELECT *
        FROM `pab7o_posts` AS `p` 
        INNER JOIN `pab7o_users` AS `u` ON `id_users` = `u`.`id` ';
        $request = $this->db->prepare($query);
        $request->execute();
        return $request->fetchAll(PDO::FETCH_OBJ);
    }
}
