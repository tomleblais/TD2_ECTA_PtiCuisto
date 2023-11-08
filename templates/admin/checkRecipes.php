<?php $title = "valider recette"; ?>

<?php ob_start(); ?>

<h1>Recettes non validé</h1>

<?php foreach ($recipes as $recipe): ?>
<div>
    <h2><a href="index.php?action=viewRecipeUncheck&id=<?= $recipe->rec_id ?>"><?= $recipe->rec_title ?></a></h2>
</div>
<?php endforeach; ?>

<?php $content = ob_get_clean(); ?>

<?php require('./templates/layout.php') ?>