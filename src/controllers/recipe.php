<?php

namespace Application\Controllers\Recipe;

require_once('./src/model/recipe.php');
require_once('./src/model/comment.php');
require_once('./src/model/user.php');

use Application\Model\Recipe\RecipeModel;
use Application\Model\Comment\CommentModel;
use Application\Model\User\UserManager;

class Recipe {
    public function showRecipe(int $id) {
        $recipeModel = new RecipeModel();

        $recette = $recipeModel->getRecipe($id);
        $comments = (new CommentModel())->getComments($id);
        $modify = false;

        if (
            (isset($_SESSION['type']) && $_SESSION['type'] === UserManager::ADMIN)
            || (isset($_SESSION['$id']) && $_SESSION['$id'] === $recipeModel->getAutor($id))
        ) {
            $modify = true;
        }

        require('./templates/showRecipe.php');
    }

    public function modifyRecipe(int $id) {
        $recipe = (new RecipeModel())->getRecipe($id);
        require('./templates/editer/modifyRecipe.php');
    }
}
