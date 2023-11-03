<?php $title = "recettes"; ?>

<?php ob_start(); ?>
<h1>Recettes</h1>

<!-- Show filtered recipes -->
<?php foreach ($recipes as $recipe): ?>
<div>
    <h2><?= $recipe->rec_title ?></h2>
</div>
<?php endforeach; ?>

<?php $content = ob_get_clean(); ?>

<?php require('layout.php') ?>