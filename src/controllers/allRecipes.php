<?php

namespace Application\Controllers\AllRecipes;

require_once('src/model/recipe.php');

use Application\Model\Recipe\RecipeModel;

class AllRecipes {
    public function execute() {
        $recipes = (new RecipeModel())->getRecipes();

        require('templates/user/allRecipes.php');
    }
}
