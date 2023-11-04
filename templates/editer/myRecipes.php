<?php $title = "mes recettes"; ?>

<?php ob_start(); ?>

<!-- Contenue de la page -->
<h1>Mes recettes</h1>

<?php $content = ob_get_clean(); ?>

<?php require('./templates/layout.php') ?>