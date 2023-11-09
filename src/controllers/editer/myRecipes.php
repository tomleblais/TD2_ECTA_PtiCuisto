<?php

namespace Application\Controllers\Editer\MyRecipes;

require_once('./src/model/recipe.php');

use Application\Model\Recipe\RecipeModel;

class MyRecipes {
    public function execute(int $id) {
        $recipes = (new RecipeModel())->getMyRecipes($id);

        require('./templates/editer/myRecipes.php');
    }
}
