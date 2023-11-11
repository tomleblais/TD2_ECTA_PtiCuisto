<?php $title = "$recipe->rec_title"; ?>

<?php ob_start(); ?>

<?php
if ($recipe->rec_modification_date === "0000-00-00 00:00:00") { //$recipe->rec_modification_date === "0000-00-00 00:00:00") {
    $date = $recipe->rec_creation_date;
} else {
    $date = $recipe->rec_modification_date . "<em> modifié</em>";
}
?>

<div class="recipe-details-container">
    <h1><?= $recipe->rec_title ?></h1>
    <div class="publication-info">
        <p>
            Posté par <span class="author"><?= $recipe->use_nickname ?></span>,<br>
            le <span class="date"><?= $date ?></span>
        </p>
    </div>
    <img src="./img/recipes/<?= $recipe->rec_image ?>" alt="Image de la recette en question" class="recipe-image">
    
    <div class="tag-container">
        <?php foreach ($recipe->tags as $tag) : ?>
        <span class="tag"><?= $tag ?></span>
        <?php endforeach; ?>
    </div>
    <div class="recipe-details-content">
        <h3>recipe</h3>
        <p>
        <?= $recipe->rec_summary ?>
        </p>
    </div>
</div>
<div class="comment-container">
    <h3>Commentaires</h3>
<?php if(!(empty($comments))) : foreach ($comments as $comment) : ?>
    <div class="comment container">
        <h5 class="comment-author author"><?= $comment->use_nickname ?></h3>
        <div class="publication-info">
            <p>Posté le <span class="date"><?= $comment->com_date ?></span></p>
        </div>
        <p class="comment-content"><?= $comment->com_content ?></p>
    </div>
<?php endforeach; 
else :
    echo "<div><em>Il n'y a pas de commentaire</em></div>";
endif;
?>
</div>

<?php if ($modify) : ?>
<form action="index.php?action=updateRecipe&id=<?= $id ?>" method="POST">
    <button type="submit">Modifier</button>
</form>
<?php endif ?>

<?php $content = ob_get_clean(); ?>

<?php require('./templates/layout.php') ?>