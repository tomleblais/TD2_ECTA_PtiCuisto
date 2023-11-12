<?php $title = "Erreur404"; ?>

<?php ob_start(); ?>
<h1>Votre page est introuvable</h1>
<?php $content = ob_get_clean(); ?>

<?php require('./src/views/layout.php') ?>