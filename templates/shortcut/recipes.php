<div class="recipe-container">
    <?php foreach ($recipes as $recipe): ?>
    <a href="./index.php?action=showRecipe&id=<?= $recipe->rec_id ?>">
        <div class="recipe">
            <div class="recipe-left">
                <img src="./img/recipes/<?= $recipe->rec_image ?>" alt="Image de la recette en question" class="recipe-image">
            </div>
            <div class="recipe-right">
                <h3><?= $recipe->rec_title ?></h3>
                <p><?= substr($recipe->rec_summary, 0, 500) . "..." ?></p>
            </div>
        </div>
    </a>
    <?php endforeach; ?>
</div>