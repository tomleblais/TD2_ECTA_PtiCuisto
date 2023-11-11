<?php

namespace Application\Controllers\Admin\CheckRecipes;

require_once('src/model/recipe.php');

use Application\Model\Recipe\RecipeModel;

class CheckRecipes {
    public function execute() {
        $recipes = (new RecipeModel())->getRecipes(0);

        require('./templates/admin/checkRecipes.php');
    }
}
