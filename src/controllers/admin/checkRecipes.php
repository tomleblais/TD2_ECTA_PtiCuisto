<?php

namespace Application\Controllers\Admin\CheckRecipes;

require_once('src/model/admin/checkRecipes.php');

use Application\Model\Admin\CheckRecipes\CheckRecipesModel;

class CheckRecipes {
    public function execute() {
        $checkRecipesModel = new CheckRecipesModel();

        require('templates/admin/checkRecipes.php');
    }
}
