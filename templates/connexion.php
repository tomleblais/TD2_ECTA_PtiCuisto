<?php $title = "connection"; ?>

<?php ob_start(); ?>

<!-- Contenue de la page -->

<form action="index.php?action=login" method="POST">
    <input type="email" name="email" id="email">
    <input type="password" name="password" id="password">
    <button type="submit">Se connecter</button>
</form>

<?php $content = ob_get_clean(); ?>

<?php require('./templates/layout.php') ?>