<?php $title = "Mes recettes"; ?>

<?php ob_start(); ?>
<h1>Mes recettes</h1>

<?php require('./src/views/user/shortcut/recipes.php') ?>



<div class="form-container container">
    <h1>Proposer une recette</h1>

    <?php if (isset($error) && $error !== "") :  ?>
        <p><?= $error ?></p>
    <?php endif; ?>

    <form action="./index.php?action=addRecipePost" method="post">
        <table>
            <tbody>
                <tr>
                    <td><label for="title">Nom de la recette :</label></td>
                    <td><input type="text" name="title" id="title"  maxlength="32" required></td>
                </tr>
                <tr>
                    <td><label for="category">Catégorie de la recette :</label></td>
                    <td><select type="text" name="category" id="category" required>
                        <option value="1">Entrée</option>
                        <option value="2">Plat</option>
                        <option value="3">Dessert</option>
                        <option value="4">Apéritif</option>
                    </select></td>
                </tr>
                <tr>
                    <td><label for="summary">Description de la recette (étapes) :</label></td>
                    <td><textarea id="summary" name="summary" rows="10" cols="33" placeholder="Description de la recette ..."></textarea></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2"><button type="submit">Proposer la recette&mldr;</button></td>
                </tr>
            </tfoot>
        </table>
    </form>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('./src/views/layout.php') ?>