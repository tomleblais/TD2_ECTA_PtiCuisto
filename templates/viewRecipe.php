<?php $title = "recette"; ?>

<?php ob_start(); ?>

<?php /*if (false) { //$recette->rec_modification_date === "0000-00-00 00:00:00") {
    $date = $recette->rec_creation_date;
} else {
    $date = $recette->rec_modification_date;
}
<!-- /* <?php foreach ($tags as $tag) : ?>
                <span><?= $tag ?></span>
            <?php endforeach; ?> -->
*/ ?>


<div>
    <div>
        <!-- <img src=alt="Image de la recette en question" /> -->
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

<?php foreach ($comments as $comment) : ?>
    <div>
        <h3><?= $comment->use_nickname ?></h3>
        <p><?= $comment->com_date ?></p>
        <p><?= $comment->com_content ?></p>
    </div>
<?php endforeach; ?>

<?php $content = ob_get_clean(); ?>

<?php require('./templates/layout.php') ?>