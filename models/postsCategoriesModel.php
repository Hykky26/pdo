<?php
class postsCategories  {
    public $id;
    public $name;
    private $db;

    public function __construct() {
        try{
            $this->db = new PDO('mysql:host=localhost;dbname=la-manu-post;charset=utf8', 'pab7o_admin', 'MZb35g78uP6Ngs');
        } catch(PDOException $e) {
            //Renvoyer vers une page d'erreur
        }
    }

    /**
     * Récupère la liste des catégories d'article pour le formulaire d'ajout d'articles
     * @return array Retourne un tableau d'objets
     */
    public function getList() {
        $query = 'SELECT `id`, `name` FROM `pab7o_postscategories` ORDER BY `name` ASC;';
        /**
         * Dans cette requête, aucune information ne dépend d'un formulaire. Dans ce cas pas de marqueur nominatif, pas de prepare et pas d'execute.
         * On utilise alors query qui permet d'executer directement la requête.
         * Attention, on peut utiliser query pour d'autres requêtes que le SELECT mais c'est un cas beaucoup plus rare.
         */
        $request = $this->db->query($query);
        /**
         * Quand on fait une requête SELECT, on utilise toujours un fetch ou un fetchAll pour récupérer les données.
         * fetch permet de récupérer une seule ligne de résultat (un user, un nombre)
         * fetchAll permet de récupérer toutes les lignes de résultat (tous les users, tous les articles publiés aujourd'hui)
         * Pour le format de récupération des données, il y a plusieurs choix possibles.
         * Ici, comme mon code est orienté objet , je préfère travailler avec des objets.
         */
        return $request->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Vérifie si une catégorie existe déjà via son id
     * @param int $id Id de la catégorie
     * @return int Retourne le nombre de fois où l'id a été trouvé dans la base de données
     */
    public function checkIfExists() {
        $query = 'SELECT COUNT(*) FROM `pab7o_postscategories` WHERE id = :id;';
        $request = $this->db->prepare($query);
        $request->bindValue(':id', $this->id, PDO::PARAM_INT);
        $request->execute();
        //Ici j'utilise fetchColumn car je n'ai besoin que d'une seule information, le nombre de lignes retournées par la requête. Donc j'utiliser fetchColumn qui me retourne directement cette information sans intermédiaire.
        return $request->fetch(PDO::FETCH_COLUMN);
    }
}
