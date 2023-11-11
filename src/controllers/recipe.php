<?php

namespace Application\Controllers\Recipe;

require_once('./src/model/recipe.php');
require_once('./src/model/comment.php');

use Application\Model\Recipe\Recipe;
use Application\Model\Recipe\RecipeModel;
use Application\Model\Comment\CommentModel;

class Recipe_c {
    public function showRecipe(int $id, int $modify) {
        $recette = (new RecipeModel())->getRecipe($id);
        $comments = (new CommentModel())->getComments($id);
        require('./templates/showRecipe.php');
    }

    public function allRecipes() {
        $recipes = (new RecipeModel())->getRecipes();
        require('./templates/allRecipes.php');
    }
    public function myRecipes(int $id) {
        $recipes = (new RecipeModel())->getMyRecipes($id);
        require('./templates/editer/myRecipes.php');
    }

    public function updateRecipe(int $id) {
        $recipe = (new RecipeModel())->getRecipe($id);
        require('./templates/editer/modifyRecipe.php');
    }

    public function updateRecipePost(int $id) {
        $recipe = new Recipe();
        $recipe->rec_id = $id;

        if (isset($_POST['title'])) {
            $recipe->rec_title = $_POST['title'];
        } else {
            throw new \Exception('updateRecipePost $_Post' . "['title']" . ' non rélgée !');
        }

        if (isset($_POST['summary'])) {
            $recipe->rec_summary = $_POST['summary'];
        } else {
            throw new \Exception('updateRecipePost $_Post' . "['summary']" . ' non rélgée !');
        }

        (new RecipeModel())->updateRecipePost($recipe);
        header("Location: ./index.php?action=showRecipe&id=$id");
    }

    public function deleteRecipe(int $id) {
        (new RecipeModel())->deleteRecipe($id);
        header("Location: ./index.php");
    }
}