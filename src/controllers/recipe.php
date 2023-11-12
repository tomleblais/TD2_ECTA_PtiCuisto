<?php

namespace Application\Controllers\Recipe;

require_once('./src/model/recipe.php');
require_once('./src/model/comment.php');

use Application\Model\Recipe\Recipe;
use Application\Model\Recipe\RecipeModel;
use Application\Model\Comment\CommentModel;

class Recipe_c {
    public function showRecipe(int $id, int $modify) {
        $recipe = (new RecipeModel())->getRecipe($id);
        $comments = (new CommentModel())->getComments($id);
        require('./templates/showRecipe.php');
    }

    public function showRecipeUncheck(int $id) {
        $recipe = (new RecipeModel())->getRecipe($id);
        require('./templates/admin/showRecipeUncheck.php');
    }

    public function allRecipes() {
        $recipes = (new RecipeModel())->getRecipes();
        require('./templates/allRecipes.php');
    }
    public function myRecipes(int $id) {
        $recipes = (new RecipeModel())->getMyRecipes($id);
        require('./templates/editer/myRecipes.php');
    }

    public function addRecipe() {
        require('./templates/editer/addRecipe.php');
    }

    public function checkRecipes() {
        $recipes = (new RecipeModel())->getRecipes(0);
        require('./templates/admin/checkRecipes.php');
    }

    public function checkRecipe(int $id) {
        if ((new RecipeModel())->checkRecipe($id)) {
            throw new \Exception("La recette n'a pas pu être validée !");
        } else {
            header("Location: ./index.php?action=checkRecipes");
        }
    }

    public function updateRecipe(int $id, string $error = "") {
        $recipe = (new RecipeModel())->getRecipe($id);
        require('./templates/editer/updateRecipe.php');
    }

    public function updateRecipePost(int $id) {
        $recipe = new Recipe();
        $recipe->rec_id = $id;

        if (!isset($_POST['title'])) {
            return "Le titre ne peux pas être vide.";
        } elseif (!isset($_POST['summary'])) {
           return "Le contenue ne peux pas être vide.";
        }

        $recipe->rec_title = $_POST['title'];
        $recipe->rec_summary = $_POST['summary'];

        if (mb_strlen($recipe->rec_title, 'UTF-8') > 32) {
            return "Le titre ne peut pas faire plus de 32 caractères.";
        } elseif (mb_strlen($recipe->rec_title, 'UTF-8') < 3) {
            return "Le titre ne peut pas faire moins de 3 caractères";
        } elseif (mb_strlen($recipe->rec_summary, 'UTF-8') > 4096) {
            return "Le contenue ne peut pas faire plus de 4096 caractères.";
        } elseif (mb_strlen($recipe->rec_summary, 'UTF-8') < 3) {
            return "Le contenue ne peut pas faire moins de 3 caractères";
        }

        (new RecipeModel())->updateRecipePost($recipe);
    }

    public function addRecipePost(){
        $recipe = new Recipe();
        $recipe->rec_id = $id;

        if (!isset($_POST['title'])) {
            return "Le titre ne peux pas être vide.";
        } elseif (!isset($_POST['summary'])) {
           return "Le contenue ne peux pas être vide.";
        }

        $recipe->rec_title = $_POST['title'];
        $recipe->rec_summary = $_POST['summary'];

        if (mb_strlen($recipe->rec_title, 'UTF-8') > 32) {
            return "Le titre ne peut pas faire plus de 32 caractères.";
        } elseif (mb_strlen($recipe->rec_title, 'UTF-8') < 3) {
            return "Le titre ne peut pas faire moins de 3 caractères";
        } elseif (mb_strlen($recipe->rec_summary, 'UTF-8') > 4096) {
            return "Le contenue ne peut pas faire plus de 4096 caractères.";
        } elseif (mb_strlen($recipe->rec_summary, 'UTF-8') < 3) {
            return "Le contenue ne peut pas faire moins de 3 caractères";
        } 

        (new RecipeModel())->addRecipe($recipe);
    }

    public function deleteRecipe(int $id) {
        (new RecipeModel())->deleteRecipe($id);
        header("Location: ./index.php");
    }

    public function filteredRecipesCategory(bool $post = false) {
        $recipeModel = new RecipeModel();
        $categories = $recipeModel->getCategories();

        if ($post) {
            if (isset($_POST['category'])) {
                $recipes = $recipeModel->getRecipesByCategory(intval($_POST['category']));
            } else {
                throw new \Exception("filteredRecipesCategory : category est vide.");
            }
        }

        require('./templates/filteredRecipesCategory.php');
    }

    public function filteredRecipesTitle(bool $post = false) {
        $recipeModel = new RecipeModel();
        $titles = $recipeModel->getRecipes();

        if ($post) {
            if (isset($_POST['title'])) {
                $recipes[] = $recipeModel->getRecipe(intval($_POST['title']));
            } else {
                throw new \Exception("filteredRecipesTitle : id est vide.");
            }
        }
        require('./templates/filteredRecipesTitle.php');
    }

    public function filteredRecipesIngredient(bool $post = false) {
        $recipeModel = new RecipeModel();
        $ingredients = $recipeModel->getIngredients();

        if ($post) {
            if (isset($_POST['ingredient'])) {
                $recipes = $recipeModel->getRecipesByIngredient(intval($_POST['ingredient']));
            } else {
                throw new \Exception("filteredRecipesIngredient : ingredient est vide.");
            }
        }
        require('./templates/filteredRecipesIngredient.php');
    }
}
