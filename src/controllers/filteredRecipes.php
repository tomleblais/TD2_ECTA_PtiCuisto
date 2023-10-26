<?php

namespace Application\Controllers\AllRecipes;

require_once('src/lib/database.php');
require_once('src/model/filteredRecipes.php');

use Application\Lib\Database\DatabaseConnection;
use Application\Model\FilteredRecipes\FilteredRecipesRepository;

class FilteredRecipes {
    public function execute(string $type, string $option) {
        $recipes = [];
        $allRecipeRepository = new FilteredRecipesRepository(new DatabaseConnection());

        switch ($type) {
            case 'category':
                $recipes = $allRecipeRepository->getFilteredRecipesByCategory(intval($option));
                break;
            case 'title':
                $recipes = $allRecipeRepository->getFilteredRecipesByTitle($option);
                break;
            case 'ingredient':
                $recipes = $allRecipeRepository->getFilteredRecipesByIngredient(intval($option));
                break;
        }

        require('templates/filteredRecipes.php');
    }
}
