<?php

namespace Application\Controllers\User\ViewRecipe;

require_once('src/model/user/viewRecipe.php');

use Application\Model\User\ViewRecipe\ViewRecipeModel;

class ViewRecipe {
    public function execute(int $id) {
        $viewRecipeModel = new ViewRecipeModel();

        require('templates/user/viewRecipe.php');
    }
}
