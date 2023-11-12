<?php $title = ""; ?>

<?php ob_start(); ?>

<h1>Les utilisateurs du site</h1>

<div class="container">
    <?php foreach ($users as $user): ?>
        <div class="user">
            <h5><?= $user->name?></h5>
            <form action="index.php?action=disableUserPost&use_id=<?= $user->use_id?>" method="post"><button type="submit">Suspendre le compte</button></form>
            
        </div>
    <?php endforeach; ?>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('./templates/layout.php') ?>