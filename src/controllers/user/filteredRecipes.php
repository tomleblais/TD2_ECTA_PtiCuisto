<?php

namespace Application\Controllers\User\FilteredRecipes;

require_once('src/model/user/filteredRecipes.php');

use Application\Model\User\FilteredRecipes\FilteredRecipesRepository;

class FilteredRecipes {
    public function execute(string $type, string $option) {
        $recipes = [];
        $allRecipeRepository = new FilteredRecipesRepository();

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

        require('templates/user/filteredRecipes.php');
    }
}
