<?php $title = "Inscription"; ?>

<?php ob_start(); ?>

<!-- Contenue de la page -->

<form action="" method="POST">
    <input type="text" name="nickname" id="nickname">
    <input type="email" name="email" id="email">
    <input type="text" name="firstname" id="firstname">
    <input type="text" name="lastname" id="lastname">
    <input type="password" name="password" id="password">
    <button type="submit"> S'inscrire </button>
</form>

<?php $content = ob_get_clean(); ?>

<?php require('./templates/layout.php') ?>