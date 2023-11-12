<?php $title = "Toutes les recettes"; ?>

<?php ob_start(); ?>
<h1>Tous les utilisateurs</h1>

<?php require('./src/views/user/shortcut/recipes.php') ?>

<?php $content = ob_get_clean(); ?>

<?php require('./src/views/layout.php') ?>
