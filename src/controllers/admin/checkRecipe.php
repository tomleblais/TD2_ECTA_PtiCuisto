<?php

namespace Application\Controllers\Admin\CheckRecipe;

require_once('src/model/recipe.php');

use Application\Model\Recipe\RecipeModel;

class CheckRecipe {
    public function execute(int $id) {
        if ((new RecipeModel())->checkRecipe($id)) {
            throw new \Exception("La recette n'a pas pu être validée !");
        } else {
            header("Location: index.php?action=checkRecipes");
        }
    }
}
