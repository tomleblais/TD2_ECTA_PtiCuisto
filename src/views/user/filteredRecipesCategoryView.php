<?php $title = "Filtrer les recettes"; ?>

<?php ob_start(); ?>

<h1>Filtrer les recettes</h1>

<form action="index.php?action=filteredRecipesCategory&post=true" method="POST">
    <label for="category">Sélectionné une catégorie :</label>
    <select name="category" id="category">
        <?php foreach ($categories as $category) : ?>
            <?php if (isset($_POST['category']) && $category->cat_id == intval($_POST['category'])) : ?>
                <option value="<?= $category->cat_id ?>" selected><?= $category->cat_title ?></option>
            <?php else : ?>
                <option value="<?= $category->cat_id ?>"><?= $category->cat_title ?></option>
            <?php endif; ?>
        <?php endforeach; ?>
    </select>

    <button type="submit">Rechercher</button>
</form>

<?php if ($post): ?> 
    <h2>Voici les recettes :</h2>
    <?php require('./src/views/user/shortcut/recipes.php'); ?>
<?php endif ?>

<?php $content = ob_get_clean(); ?>

<?php require('./src/views/layout.php') ?>