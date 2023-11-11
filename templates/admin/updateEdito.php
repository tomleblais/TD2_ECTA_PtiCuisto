<?php $title = "modifier edito"; ?>

<?php ob_start(); ?>

<h1>Modifier l'edito :</h1>

<?php if($error !== "") : ?>
    <p><?= $error ?></p>
<?php endif; ?>

<form action="index.php?action=updateEditoPost" method="POST">
    <label for="content">Contenue :</label>
    <textarea id="content" name="content"><?= $content ?></textarea>

    <button type="submit">Modifier</button>
</form>
<form action="index.php" method="POST">
    <button type="submit">Annuler</button>
</form>

<?php $content = ob_get_clean(); ?>

<?php require('./templates/layout.php') ?>