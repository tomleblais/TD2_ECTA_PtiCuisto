<?php $title = "Mes recettes"; ?>

<?php ob_start(); ?>
<h1>Mes recettes</h1>

<?php require('./templates/shortcut/recipes.php') ?>

<?php $content = ob_get_clean(); ?>

<?php require('./templates/layout.php') ?>