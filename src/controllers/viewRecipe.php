<?php

namespace Application\Controllers\ViewRecipe;

require_once('./src/model/recipe.php');
require_once('./src/model/comment.php');

use Application\Model\Recipe\RecipeModel;
use Application\Model\Comment\CommentModel;

class ViewRecipe {
    public function execute(int $id) {
        $recette = (new RecipeModel())->getRecipe($id);
        $comments = (new CommentModel())->getComments($id);

        require('./templates/viewRecipe.php');
    }
}
