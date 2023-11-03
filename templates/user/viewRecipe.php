<?php $title = "recette"; ?>

<?php ob_start(); ?>

<!-- Contenue de la page -->

<?php $content = ob_get_clean(); ?>

<?php require('./templates/layout.php') ?>