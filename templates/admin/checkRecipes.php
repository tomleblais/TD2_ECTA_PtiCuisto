<?php $title = "valider recette"; ?>

<?php ob_start(); ?>

<h1>Recettes non validé</h1>

<div class="recipe-container">
    <?php foreach ($recipes as $recipe): ?>
    <a href="index.php?action=showRecipeUncheck&id=<?= $recipe->rec_id ?>">
        <div class="recipe">
            <div class="recipe-left">
                <img src="./img/recipes/<?= $recipe->rec_image ?>" alt="Image de la recette en question" class="recipe-image">
            </div>
            <div class="recipe-right">
                <h3><?= $recipe->rec_title ?></h3>
                <p><?= substr($recipe->rec_summary, 1, 500) . "..." ?></p>
            </div>
        </div>
    </a>
    <?php endforeach; ?>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('./templates/layout.php') ?>