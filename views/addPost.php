<main>
    <h1>Ajouter un article</h1>
    <div>
        <?php if (isset($success)) { ?>
            <p class="successText"><?= $success ?></p>
        <?php } ?>
    </div>
    <form action="#" method="post" enctype="multipart/form-data">
        <label for="title">Titre</label>
        <input type="text" name="title" id="title" placeholder="Septembre" value="<?= @$_POST['title'] ?>">
        <?php if (isset($formErrors['title'])) { ?>
            <p class="errorText"><?= $formErrors['title'] ?></p>
        <?php } ?>


        <label for="content">Content</label>
        <textarea name="content" id="content" placeholder="..."><?= @$_POST['content'] ?></textarea>
        <?php if (isset($formErrors['content'])) { ?>
            <p class="errorText"><?= $formErrors['content'] ?></p>
        <?php } ?>

        <label for="image">Image</label>
        <input type="file" name="image" id="image">
        <?php if (isset($formErrors['image'])) { ?>
            <p class="errorText"><?= $formErrors['image'] ?></p>
        <?php } ?>

        <!-- 
        Liste des catégories : partie 2 / 2
        $pcList est un tableau d'objet : Je dois le parcourir comme un tableau et traiter chaque donnée comme un objet.
        Pour le tableau, je vais utiliser la boucle dédiée aux tableaux en php : le foreach.
        Le but est que pour chaque ligne du tableau, je crée une option dans la liste déroulante.
        $pcItem représente chaque élement du tableau, $pcList étant un tableau d'objet, $pcItem est un objet.
        Cet objet a pour attribut les élements présents après le SELECT dans la requête SQL.
        Ici la requête utilisée est :
            $query = 'SELECT `id`, `name` FROM `pab7o_postscategories` ORDER BY `name` ASC;';
        Les deux attributs de l'objet $pcItem sont donc id et name.
        Je mets l'id dans la value pour qu'il soit envoyé avec le formulaire et $name entre les balises option pour l'afficher à l'utilisateur.
     -->
        <label for="id_postsCategories">Catégorie</label>
        <select name="id_postsCategories" id="id_postsCategories">
            <?php foreach ($pcList as $pcItem) { ?>
                <option value="<?= $pcItem->id ?>" <?= isset($_POST['id_postsCategories']) && $_POST['id_postsCategories'] == $pcItem->id ? 'selected' : '' ?>><?= $pcItem->name ?></option>
            <?php } ?>
        </select>
        <?php if (isset($formErrors['id_postsCategories'])) { ?>
            <p class="errorText"><?= $formErrors['id_postsCategories'] ?></p>
        <?php } ?>

        <input type="submit" value="Publier">


    </form>
</main>