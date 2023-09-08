<main>
    <h1>Inscription</h1>

    <?php if (isset($formErrors['general'])) { ?>
        <p><?= $formErrors['general'] ?></p>
    <?php } ?>

    <?php if (isset($success)) { ?>
        <div>
            <p class="successText"><?= $success ?></p>
            <p>Vous pouvez <a href="">vous connecter</a> dès maintenant.</p>
        </div>
    <?php } else { ?>

        <form action="" method="post">

            <label for="username">Nom d'utilisateur</label>
            <input type="text" name="username" id="username" placeholder="Globox" value="<?= @$_POST['username'] ?>">
            <?php if (isset($formErrors['username'])) { ?>
                <p class="errorText"><?= $formErrors['username'] ?></p>
            <?php } ?>

            <label for="email">Adresse e-mail</label>
            <input type="email" name="email" id="email" placeholder="globox@gmail.com" value="<?= @$_POST['email'] ?>">
            <?php if (isset($formErrors['email'])) { ?>
                <p class="errorText"><?= $formErrors['email'] ?></p>
            <?php } ?>

            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password" placeholder="********">
            <?php if (isset($formErrors['password'])) { ?>
                <p class="errorText"><?= $formErrors['password'] ?></p>
            <?php } ?>

            <label for="passwordConfirm">Confirmation du mot de passe</label>
            <input type="password" name="passwordConfirm" id="passwordConfirm" placeholder="********">
            <?php if (isset($formErrors['passwordConfirm'])) { ?>
                <p class="errorText"><?= $formErrors['passwordConfirm'] ?></p>
            <?php } ?>

            <label for="birthdate">Date de naissance</label>
            <input type="date" name="birthdate" id="birthdate" value="<?= @$_POST['birthdate'] ?>">
            <?php if (isset($formErrors['birthdate'])) { ?>
                <p><?= $formErrors['birthdate'] ?></p>
            <?php } ?>

            <input type="submit" value="Inscription">
        </form>
    <?php } ?>
</main>