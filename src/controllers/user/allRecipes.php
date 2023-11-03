<?php

namespace Application\Controllers\User\AllRecipes;

require_once('src/model/user/allRecipes.php');

use Application\Model\User\AllRecipes\AllRecipeRepository;

class AllRecipes {
    public function execute() {
        $allRecipeRepository = new AllRecipeRepository();
        $recipes = $allRecipeRepository->getRecipes();

        require('templates/allRecipes.php');
    }
}
