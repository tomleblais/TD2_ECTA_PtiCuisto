<?php $title = "Petit Cuisto"; ?>

<?php ob_start(); ?>
<h1>Petit cuisto</h1>

<a href="index.php?action=connexion">Connexion</a><br>

<a href="index.php?action=allRecipes">Toutes les recettes</a><br>
<a href="index.php?action=filteredRecipes">Recettes filtrées</a><br>
<a href="index.php?action=viewRecipe">Recette</a><br>

<a href="index.php?action=addRecipe">Ajouter une recette</a><br>
<a href="index.php?action=myRecipes">Mes recettes</a><br>
<a href="index.php?action=updateRecipe">Modifier une recette</a><br>

<a href="index.php?action=checkRecipes">Valider les recettes</a><br>
<a href="index.php?action=updateEdito">Modifier l'edito</a><br>

<?php $content = ob_get_clean(); ?>

<?php require('layout.php') ?>