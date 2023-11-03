<?php

namespace Application\Controllers\User\AllRecipes;

require_once('src/lib/database.php');
require_once('src/model/user/allRecipes.php');

use Application\Lib\Database\DatabaseConnection;
use Application\Model\User\AllRecipes\AllRecipeRepository;

class AllRecipes {
    public function execute() {
        $allRecipeRepository = new AllRecipeRepository(new DatabaseConnection());
        $recipes = $allRecipeRepository->getRecipes();

        require('templates/allRecipes.php');
    }
}
