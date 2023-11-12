<?php

use Application\Model\User\UserManager;

$title = "$user->use_nickname"; ?>

<?php ob_start(); ?>

<h1><?= $user->use_nickname ?></h1>

<h2>Nom d'utilisateur</h2>
<p><?= $user->use_nickname ?></p>

<h2>Prénom :</h2>
<p><?= $user->use_firstname ?></p>

<h2>Nom :</h2>
<p><?= $user->use_lastname ?></p>

<h2>Email :</h2>
<p><?= $user->use_email ?></p>

<h2>Type d'utilisateur</h2>
>>>>>>> 97b373836ec9f6bdd37c1de9fbd78ab62d065ff2
<p><?= ($user->uty_id == UserManager::ADMIN) ? "Administrateur" : "Editeur" ?></p>

<?php $content = ob_get_clean(); ?>

<?php require('./templates/layout.php') ?>