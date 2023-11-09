<?php

namespace Application\Controllers\Editer\MyRecipes;

require_once('src/model/recipe.php');

use Application\Model\Recipe\RecipeModel;

class MyRecipes {
    public function execute(int $id) {
        $myRecipeModel = new RecipeModel();

        require('./templates/editer/myRecipes.php');
    }
}
