<?php $title = "Petit Cuisto"; ?>

<?php ob_start(); ?>
<h1>Petit cuisto</h1>

<a href="index.php?action=login">Connexion</a><br>
<a href="index.php?action=logout">Déconnexion</a><br>
<br>
<a href="index.php?action=myRecipes">Mes recettes</a><br>
<a href="index.php?action=addRecipe">Ajouter une recette</a><br>
<br>
<a href="index.php?action=allRecipes">Toutes les recettes</a><br>
<a href="index.php?action=filteredRecipes">Recettes filtrées</a><br>
<br>
<a href="index.php?action=checkRecipes">Valider les recettes</a><br>
<a href="index.php?action=updateEdito">Modifier l'edito</a><br>

<?php $content = ob_get_clean(); ?>

<?php require('./templates/layout.php') ?>