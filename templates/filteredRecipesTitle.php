<?php $title = "Filtrer les recettes"; ?>

<?php ob_start(); ?>

<h1>Filtrer les recettes</h1>

<form action="index.php?action=filteredRecipesTitle&post=true" method="POST">
    <label for="title">Sélectionné un titre :</label>
    <select name="title" id="title">
        <?php foreach ($titles as $titleF) : ?>
            <?php if (isset($_POST['title']) && $titleF->rec_id == intval($_POST['title'])) : ?>
                <option value="<?= $titleF->rec_id ?>" selected><?= $titleF->rec_title ?></option>
            <?php else : ?>
                <option value="<?= $titleF->rec_id ?>"><?= $titleF->rec_title ?></option>
            <?php endif; ?>
        <?php endforeach; ?>
    </select>

    <button type="submit">Rechercher</button>
</form>

<?php if ($post): ?> 
    <h2>Voici les recettes :</h2>
    <?php require('./templates/shortcut/recipes.php'); ?>
<?php endif ?>

<?php $content = ob_get_clean(); ?>

<?php require('./templates/layout.php') ?>