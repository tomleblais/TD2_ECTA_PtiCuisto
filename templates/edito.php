<?php $title = "Petit Cuisto"; ?>

<?php ob_start(); ?>
<h1>Petit cuisto</h1>

<div class="banner-container">
    <img src="https://assets.afcdn.com/story/20220126/2157919_w472h265c1cx1063cy706cxt0cyt0cxb2125cyb1411.webp" alt="" class="banner-image" width="100%">
</div>

<div class="main-container">
    <div class="main-container-left container">
        <h1>Les dernières recettes</h1>
        <div class="recipe-container">
            <?php foreach ($recipes as $recipe): ?>
                <a href="./index.php?action=showRecipe&id=<?= $recipe->rec_id ?>">
                    <div class="recipe">
                        <div class="recipe-left">
                            <img src="./img/recipes/<?= $recipe->rec_image ?>" alt="" class="recipe-image">
                        </div>
                        <div class="recipe-right">
                            <h3><?= $recipe->rec_title ?></h3>
                            <p class="recipe-content">
                                <?= $recipe->rec_summary ?>
                            </p>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="main-container-right secondary container">
        <img src="https://assets.afcdn.com/story/20220126/2157919_w472h265c1cx1063cy706cxt0cyt0cxb2125cyb1411.webp" alt="" width="100" height="100" class="edito-image">
        <h1 class="edito-title">Edito</h1>
        <div class="edito-content">
            <p class="edito-paragraph"><?= $content ?></p>
            <?php if($update): ?>
                <form action="index.php?action=updateEdito" method="POST">
                    <button type="submit">Modifier</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('./templates/layout.php') ?>

<?php 
