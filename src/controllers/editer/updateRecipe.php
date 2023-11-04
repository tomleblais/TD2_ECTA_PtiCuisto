<?php

namespace Application\Controllers\Editer\UpdateRecipe;

require_once('src/model/editer/updateRecipe.php');

use Application\Model\Editer\UpdateRecipe\UpdateRecipeModel;

class UpdateRecipe {
    public function execute() {
        $updateRecipeModel = new UpdateRecipeModel();

        require('templates/editer/updateRecipe.php');
    }
}
