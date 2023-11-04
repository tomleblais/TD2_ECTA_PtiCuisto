<?php $title = "toutes les recettes"; ?>

<?php ob_start(); ?>
<h1>All recipes</h1>

<!-- Show all recipes -->
<?php foreach ($recipes as $recipe): ?>
<div>
    <h2><?= $recipe->rec_title ?></h2>
</div>
<?php endforeach; ?>

<?php $content = ob_get_clean(); ?>

<?php require('./templates/layout.php') ?>