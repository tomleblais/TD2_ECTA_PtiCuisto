<?php $title = "Toutes les recettes"; ?>

<?php ob_start(); ?>
<h1>Toutes les recettes</h1>

<div class="recipe-container">
    <?php foreach ($recipes as $recipe): ?>
    <div class="recipe">
        <div class="recipe-left">
            <a href="./index.php?action=showRecipe&id=<?= $recipe->rec_id ?>">
            <img src="./img/recipes/<?= $recipe->rec_image ?>" alt="Image de la recette en question" class="recipe-image">
            </a>
        </div>
        <div class="recipe-right">
            <h3><a href="./index.php?action=showRecipe&id=<?= $recipe->rec_id ?>"><?= $recipe->rec_title ?></a></h3>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('./templates/layout.php') ?>
