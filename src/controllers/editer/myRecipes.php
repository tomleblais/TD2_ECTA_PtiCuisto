<?php

namespace Application\Controllers\Editer\MyRecipes;

require_once('src/model/editer/myRecipes.php');

use Application\Model\Editer\MyRecipes\MyRecipesModel;

class MyRecipes {
    public function execute() {
        $myRecipeModel = new MyRecipesModel();

        require('templates/editer/myRecipes.php');
    }
}
