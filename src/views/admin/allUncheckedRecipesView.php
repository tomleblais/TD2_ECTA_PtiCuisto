<?php $title = "recettes"; ?>

<?php ob_start(); ?>

<h1><?= $recipe->rec_title ?></h1>
<div><?= $recipe->rec_summary ?></div>

<form action="index.php?action=checkRecipe&id=<?= $id ?>" method="POST">
    <button type="submit">Valider</button>
</form>
<form action="index.php?action=checkRecipes" method="POST">
    <button type="submit">Annuler</button>
</form>

<?php $content = ob_get_clean(); ?>

<?php require('./src/views/layout.php') ?>