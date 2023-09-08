# Notions  

## PDO

  

Le PDO (PHP Data Object) est une extension PHP qui permet de **communiquer avec une base de données**. Il est disponible depuis PHP 5.1.0. Il est plus récent que l'extension MySQLi (MySQL Improved) qui est disponible depuis PHP 5.0.0.

  

La différence entre MySQLi et PDO est que MySQLi ne fonctionne qu'avec MySQL, alors que PDO fonctionne avec plusieurs types de bases de données (MySQL, PostgreSQL, SQLite, etc.). Il est également plus sécurisé que MySQLi. Chacun s'utilise indépendamment du MVC.

  

## L'architecture MVC

  

L'architecture MVC (Modèle-Vue-Contrôleur) est une des manières d'organiser son code. Elle permet de séparer les différentes parties de votre application en rôles distincts.

  

### Le modèle

  

C'est le fichier dont nous allons nous servir pour **communiquer avec la base de données**. Il va donc contenir nos requêtes SQL (INSERT, SELECT, UPDATE, DELETE). Ici sous forme d'objet, il peut contenir d'autres fonctions pour le traitement des données (calculer un âge par rapport à une date de naissance, etc.). Il est essentiellement écrit en php.

```php
class users {

	public $id;
	public $username;
	public $password;
	public $birthdate;

	public __construct(){
		try{
			$this->db = new  PDO('mysql:host=localhost;dbname=la-manu-post;charset=utf8', 'pab7o_admin', '8$aa&d47EsiggY#5');
		} catch(PDOException  $e) {
			header('Location: /erreur');
			exit;
		}
	}

	public function calculateAge() {
		$date = new DateTime(); 
		$birthdate = new DateTime($this->birthdate); 
		return $date->diff($birthdate )->y;
	}
	
	public function getList() {
		$query = 'SELECT `id`, `username`, `password`, `birthdate` FROM `pab7o_users`';
		$request = $this->db->query($query);
		return  $request->fetchAll(PDO::FETCH_OBJ);
	}

}
```
### La vue

Ce fichier va gérer **l'affichage** du site et qui va contenir l'html. Dans l'idéal, il doit contenir **le moins de php possible**.

```html
<table>
	<thead>
		<tr>
			<th>Nom d'utilisateur</th>
			<th>Date de naissance</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($usersList as $u) { ?>
			<tr>
				<td><?= $u->username ?></td>
				<td><?= $u->birthdate?></td>
			</tr>
		<?php } ?>
	</tbody>
</table>
```
### Le contrôleur

Le contrôleur va être celui qui va diriger tout. Il s'occupe de charger **la vue**  (sauf pour l'index) et **le modèle**. Il contrôlera les informations qui entrent et sortent de la base de données.

Le modèle et la vue ne sont que des outils pour le contrôleur.

```php
	require_once  '../models/usersModel.php';
		
	$user = new users;
	$usersList = $user->getList();
	
	require_once  '../views/usersList.php';
```
	

