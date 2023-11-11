<?php $title = "recette"; ?>

<?php ob_start(); ?>

<form action="index.php?action=updateRecipePost&id=<?= $id ?>" method="POST">
    <label for="title">Titre :</label>
    <input type="text" id="title" name="title" value="<?= $recipe->rec_title ?>">

    <label for="summary">Contenue :</label>
    <textarea id="summary" name="summary"><?= $recipe->rec_summary ?></textarea>

    <button type="submit">Modifier</button>
</form>
<form action="index.php?action=showRecipe&id=<?= $id ?>" method="POST">
    <button type="submit">Annuler</button>
</form>
<form action="index.php?action=deleteRecipe&id=<?= $id ?>" method="POST">
    <button type="submit">Supprimer</button>
</form>

<?php $content = ob_get_clean(); ?>

<?php require('./templates/layout.php') ?>