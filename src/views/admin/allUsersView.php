<?php $title = ""; ?>

<?php ob_start(); ?>

<h1>Les utilisateurs du site</h1>

<div class="user-container">
    <?php foreach ($users as $user): ?>
    <div class="user container">
        <h5><?= $user->use_nickname ?></h5>
        <form action="./index.php?action=updateUserStatusPost&use_id=<?= $user->use_id?>" method="post">
            <select name="status" id="status">
                <option value="1" <?= $user->ust_id == 1 ? "selected" : "" ?>>Activé</option>
                <option value="2" <?= $user->ust_id == 2 ? "selected" : "" ?>>Suspendu</option>
                <option value="3" <?= $user->ust_id == 3 ? "selected" : "" ?>>Supprimé</option>
            </select>
            <button type="submit">Modifier</button>
        </form>
        </div>
    <?php endforeach; ?>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('./src/views/layout.php') ?>