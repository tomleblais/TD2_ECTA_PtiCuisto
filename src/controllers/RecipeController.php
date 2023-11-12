<?php

namespace Application\Controllers\RecipeController;

require_once('./src/models/RecipeModel.php');
require_once('./src/models/CommentModel.php');

use Application\Model\RecipeModel\Recipe;
use Application\Model\RecipeModel\RecipeManager;
use Application\Model\CommentModel\CommentManager;

class RecipeController {
    public function recipeDetails(int $id, int $modify) {
        $recipe = (new RecipeManager())->getRecipe($id);
        $comments = (new CommentManager())->getComments($id);
        
        require('./src/views/user/recipeDetailsView.php');
    }

    public function allUncheckedRecipes(int $id) {
        $recipe = (new RecipeManager())->getRecipe($id);
        
        require('./src/views/admin/allUncheckedRecipesView.php');
    }

    public function allRecipes() {
        $recipes = (new RecipeManager())->getRecipes();
        require('./src/views/user/allRecipesView.php');
    }
    public function myRecipes(int $id) {
        $recipes = (new RecipeManager())->getMyRecipes($id);
        require('./src/views/editer/myRecipesView.php');
    }

    public function addRecipe() {
        require('./src/views/editer/addRecipeView.php');
    }

    public function checkRecipes() {
        $recipes = (new RecipeManager())->getRecipes(0);
        require('./src/views/admin/checkRecipesView.php');
    }

    public function checkRecipe(int $id) {
        if ((new RecipeManager())->checkRecipe($id)) {
            throw new \Exception("La recette n'a pas pu être validée !");
        } else {
            header("Location: ./index.php?action=checkRecipes");
        }
    }

    public function updateRecipe(int $id, string $error = "") {
        $recipe = (new RecipeManager())->getRecipe($id);
        
        require('./src/views/editer/updateRecipeView.php');
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

        (new RecipeManager())->updateRecipePost($recipe);
    }

    public function addRecipePost(int $id){
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

        (new RecipeManager())->addRecipe($recipe);
    }

    public function deleteRecipe(int $id) {
        (new RecipeManager())->deleteRecipe($id);
        header("Location: ./index.php");
    }

    public function filteredRecipesCategory(bool $post = false) {
        $recipeModel = new RecipeManager();
        $categories = $recipeModel->getCategories();

        if ($post) {
            if (isset($_POST['category'])) {
                $recipes = $recipeModel->getRecipesByCategory(intval($_POST['category']));
            } else {
                throw new \Exception("filteredRecipesCategory : category est vide.");
            }
        }

        require('./src/views/user/filteredRecipesCategoryView.php');
    }

    public function filteredRecipesTitle(bool $post = false) {
        $recipeModel = new RecipeManager();
        $titles = $recipeModel->getRecipes();

        if ($post) {
            if (isset($_POST['title'])) {
                $recipes[] = $recipeModel->getRecipe(intval($_POST['title']));
            } else {
                throw new \Exception("filteredRecipesTitle : id est vide.");
            }
        }
        require('./src/views/user/filteredRecipesTitleView.php');
    }

    public function filteredRecipesIngredient(bool $post = false) {
        $recipeModel = new RecipeManager();
        $ingredients = $recipeModel->getIngredients();

        if ($post) {
            if (isset($_POST['ingredient'])) {
                $recipes = $recipeModel->getRecipesByIngredient(intval($_POST['ingredient']));
            } else {
                throw new \Exception("filteredRecipesIngredient : ingredient est vide.");
            }
        }
        require('./src/views/user/filteredRecipesIngredientView.php');
    }
}
