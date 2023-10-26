<?php $title = "Petit Cuisto"; ?>

<?php ob_start(); ?>
<h1>Petit cuisto</h1>

<?php $content = ob_get_clean(); ?>

<?php require('layout.php') ?>