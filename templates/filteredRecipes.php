<?php $title = "Recettes filtrées"; ?>

<?php ob_start(); ?>
<h1>Recettes</h1>

<!-- Show filtered recipes -->
<div class="recipe-container">
    <?php foreach ($recipes as $recipe): ?>
    <div class="recipe">
        <div class="recipe-left">
            <a href="index.php?action=showRecipe&id=<?= $recipe->rec_id ?>">
                <img src="<?= $recipe->rec_image ?>" alt="" class="recipe-image">
            </a>
        </div>
        <div class="recipe-right">
            <h3><a href="index.php?action=showRecipe&id=<?= $recipe->rec_id ?>"><?= $recipe->rec_title ?></a></h3>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('./templates/layout.php') ?>