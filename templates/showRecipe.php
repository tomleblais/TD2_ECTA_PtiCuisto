<?php $title = "recette"; ?>

<?php ob_start(); ?>

<?php
if ($recette->rec_modification_date === "0000-00-00 00:00:00") { //$recette->rec_modification_date === "0000-00-00 00:00:00") {
    $date = $recette->rec_creation_date;
} else {
    $date = $recette->rec_modification_date . "<em> modifié</em>";
}
?>

<?php foreach ($recette->tags as $tag) : ?>
    <span><?= $tag ?></span>
    <?php endforeach; ?>



<div>
    <div>
        <img src="<?= $recette->rec_image ?>" alt="Image de la recette en question" />
        <div>

        </div>
    </div>
    <div>
        <div>
            <div>
                <h2><?= $recette->rec_title ?></h2>
            </div>
            <div>
                <div><?= $recette->use_nickname ?></div>
                <div><?= $date ?></div>
            </div>
        </div>
        <p><?= $recette->rec_summary ?></p>
    </div>
</div>

<?php if(!(empty($comments))) : foreach ($comments as $comment) : ?>
    <div>
        <h3><?= $comment->use_nickname ?></h3>
        <p><?= $comment->com_date ?></p>
        <p><?= $comment->com_content ?></p>
    </div>
<?php endforeach; 
else :
    echo "<div><em>Il n'y a pas de commentaire</em></div>";
endif;
?>

<?php if ($modify) : ?>
    <form action="index.php?action=modifyRecipe&id=<?= $id ?>" method="POST">
        <button type="submit">Modifier</button>
    </form>
    <form action="index.php" method="POST">
        <button type="submit">Supprimer</button>
    </form>
<?php endif ?>

<?php $content = ob_get_clean(); ?>

<?php require('./templates/layout.php') ?>