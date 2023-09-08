<?php
// Je démarre la session pour pouvoir agir sur les variables de session et la session en elle-même
session_start();
// Je supprime les variables de session (protection bonus, normalement inutile mais le cas se présente parfois)
unset($_SESSION);
// Je détruis la session
session_destroy();
// Je redirige l'utilisateur vers la page de connexion
header('Location:/connexion');
// Je stoppe l'exécution du php pour éviter que le reste du code ne s'exécute
exit;