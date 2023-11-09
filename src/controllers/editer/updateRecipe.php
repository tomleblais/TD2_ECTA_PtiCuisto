<?php

namespace Application\Controllers\Editer\UpdateRecipe;

require_once('src/model/recipe.php');

use Application\Model\Recipe\RecipeModel;

class UpdateRecipe {
    public function execute() {
        $updateRecipeModel = new RecipeModel();

        require('./templates/editer/updateRecipe.php');
    }
}
