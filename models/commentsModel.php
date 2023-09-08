<?php
class comments {
    public int $id = 0;
    public string $content = '';
    public string $publicationDate = '';
    public int $id_posts = 0;
    public int $id_users = 0;
    private $db;

    public function __construct() {
        try{
            $this->db = new PDO('mysql:host=localhost;dbname=la-manu-post;charset=utf8', 'pab7o_admin', 'MZb35g78uP6Ngs');
        } catch(PDOException $e) {
            //Renvoyer vers une page d'erreur
        }
    }

    /**
     * Ajoute un commentaire
     * @param string content Contenu du commentaire
     * @param int id_posts Id de l'article commenté
     * @param int id_users Id de l'auteur du commentaire
     * @return bool Renvoie true si la requête est executée sinon renvoie false
     */
    public function add(){
        $query = 'INSERT INTO `pab7o_comments` (`content`, `publicationDate`, `id_posts`, `id_users`) 
        VALUES (:content, NOW(), :id_posts, :id_users);';
        $request = $this->db->prepare($query);
        $request->bindValue(':content', $this->content, PDO::PARAM_STR);
        $request->bindValue(':id_posts', $this->id_posts, PDO::PARAM_INT);
        $request->bindValue(':id_users', $this->id_users, PDO::PARAM_INT);
        return $request->execute();
    }

    /**
     * Récupère la liste des commentaires pour un post.
     * @param int id_posts id de l'article
     * @return arrayOfObjects Les commentaires de l'article
     */
    public function getListByPost() {
        $query = 'SELECT `content`, DATE_FORMAT(`publicationDate`, "%d/%m/%Y à %Hh%i") AS `publicationDate`, `username` 
        FROM `pab7o_comments` 
        INNER JOIN `pab7o_users` ON `pab7o_users`.`id` = `id_users` 
        WHERE `id_posts` = :id_posts;';
        $request = $this->db->prepare($query);
        $request->bindValue(':id_posts', $this->id_posts, PDO::PARAM_INT);
        $request->execute();
        return $request->fetchAll(PDO::FETCH_OBJ);
    }

    public function getUsersComments() {
        $query = 'SELECT content , DATE_FORMAT(publicationDate, "%d/%m/%Y à %Hh%i") AS publicationDate
        FROM pab7o_comments AS c 
        INNER JOIN pab7o_users AS u ON id_users = u.id ';
        $request = $this->db->prepare($query);
        $request->bindValue(':id', $this->id, PDO::PARAM_INT);
        $request->execute();
        return $request->fetchAll(PDO::FETCH_OBJ);
    }

 
}