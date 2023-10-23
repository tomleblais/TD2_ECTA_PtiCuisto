<?php

namespace Application\Controllers\AllRecipes;

require_once('src/lib/database.php');
require_once('src/model/recipes.php');

use Application\Lib\Database\DatabaseConnection;
use Application\Model\AllRecipes\AllRecipeRepository;

class AllRecipes {
    public function execute(string $identifier) {
        $connection = new DatabaseConnection();

        $allRecipeRepository = new AllRecipeRepository();
        $allRecipeRepository->connection = $connection;
        $recipes = $allRecipeRepository->getRecipes();

        require('templates/allRecipes.php');
    }
}
