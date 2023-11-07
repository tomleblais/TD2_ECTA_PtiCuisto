<?php

namespace Application\Controllers\Admin\CheckRecipes;

require_once('src/model/recipe.php');

use Application\Model\Recipe\RecipeModel;

class CheckRecipes {
    public function execute() {
        $checkRecipesModel = new RecipeModel();

        require('templates/admin/checkRecipes.php');
    }
}
