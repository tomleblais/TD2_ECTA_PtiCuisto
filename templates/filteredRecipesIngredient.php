<?php $title = "Filtrer les recettes"; ?>

<?php ob_start(); ?>

<h1>Filtrer les recettes</h1>

<form action="index.php?action=filteredRecipesIngredient&post=true" method="POST">
    <label for="ingredient">Sélectionné un ingredient :</label>
    <select name="ingredient" id="ingredient">
        <?php foreach ($ingredients as $ingredient) : ?>
            <?php if (isset($_POST['ingredient']) && $category->cat_id == intval($_POST['ingredient'])) : ?>
                <option value="<?= $ingredient->ing_id ?>" selected><?= $ingredient->ing_name ?></option>
            <?php else : ?>
                <option value="<?= $ingredient->ing_id ?>"><?= $ingredient->ing_name ?></option>
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