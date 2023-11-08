<?php

namespace Application\Controllers\Admin\ViewRecipeUncheck;

require_once('src/model/recipe.php');

use Application\Model\Recipe\RecipeModel;

class ViewRecipeUncheck {
    public function execute(int $id) {
        $recipe = (new RecipeModel())->getRecipeB($id);

        require('templates/admin/viewRecipeUncheck.php');
    }
}
