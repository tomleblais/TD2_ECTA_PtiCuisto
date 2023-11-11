<?php $title = "connection"; ?>

<?php ob_start(); ?>

<h1>Connection :</h1>

<?php if($error !== "") : ?>
    <p><?= $error ?></p>
<?php endif; ?>

<form action="index.php?action=loginPost" method="POST">
    <input type="email" name="email" id="email">
    <input type="password" name="password" id="password">
    <button type="submit">Se connecter</button>
</form>

<?php $content = ob_get_clean(); ?>

<?php require('./templates/layout.php') ?>