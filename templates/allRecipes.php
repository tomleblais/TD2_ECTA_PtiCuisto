<?php $title = "toutes les recettes"; ?>

<?php ob_start(); ?>
<h1>All recipes</h1>

<?php foreach ($recipes as $recipe): ?>
<div>
    <h2><a href="index.php?action=viewRecipe&id=<?= $recipe->rec_id ?>"><?= $recipe->rec_title ?></a></h2>
</div>
<?php endforeach; ?>

<?php $content = ob_get_clean(); ?>

<?php require('./templates/layout.php') ?>