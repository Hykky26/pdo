<main>
    <h1>Connexion</h1>
    <form action="" method="post">
        <label for="email">Adresse mail</label>
        <input type="email" name="email" id="email" placeholder="globox@gmail.com">
        <?php if (isset($formErrors['email'])) { ?>
            <p class="errorText"><?= $formErrors['email'] ?></p>
        <?php } ?>

        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password" placeholder="********">
        <?php if (isset($formErrors['password'])) { ?>
            <p class="errorText"><?= $formErrors['password'] ?></p>
        <?php } ?>
        <input type="submit" value="Se connecter">
    </form>
</main>