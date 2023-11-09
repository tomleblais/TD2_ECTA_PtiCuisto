<?php

namespace Application\Controllers\FilteredRecipes;

require_once('src/model/recipe.php');

use Application\Model\Recipe\RecipeModel;

class FilteredRecipes {
    public function execute(string $type, string $option) {
        $recipes = [];
        $allRecipeRepository = new RecipeModel();

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

        require('./templates/filteredRecipes.php');
    }
}
