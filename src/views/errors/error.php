<?php $title = "Erreur"; ?>

<?php ob_start(); ?>
<h1>Une erreur est survenue : <?= $errorMessage ?></h1>
<?php $content = ob_get_clean(); ?>

<?php require('./src/views/layout.php') ?>