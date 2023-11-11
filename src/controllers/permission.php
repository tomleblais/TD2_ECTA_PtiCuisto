<?php

namespace Application\Controllers\Permission;

require_once('./src/model/user.php');
require_once('./src/model/recipe.php');

use Application\Model\User\UserManager;
use Application\Model\Recipe\RecipeModel;

class Permission {
    private ?int $id;
    private int $type;
    private $user;
    private $editer;
    private $admin;
    private $special;

    public function __construct(?int $id, int $type) {
        $this->id = $id;
        $this->type = $type;

        $this->user = [
            "homepage",
            "connexion",
            "login",
            "allRecipes",
            "filteredRecipes",
            "showRecipe"
        ];

        $this->editer = [
            "addRecipe",
            "myRecipes",
        ];

        $this->admin = [
            "checkRecipes",
            "viewRecipeUncheck",
            "checkRecipe",
            "updateEdito"
        ];

        $this->special = [
            "updateRecipe",
            "updateRecipePost",
            "deleteRecipe"
        ];
    }

    public function isAllowed(string $action, $opt = null): bool {
        if (in_array($action, $this->special)) {
            switch ($action) {
            case "updateRecipe":
            case "updateRecipePost":
            case "deleteRecipe":
                if (is_nan($opt)) {
                    throw new \Exception("L'option de modificatin de la recette n'est pas un nombre. (permission.php)");
                }

                return $this->type === UserManager::ADMIN
                    || $this->id === (new RecipeModel)->getAutor($opt);
            }
        }
        
        switch ($this->type) {
        case UserManager::USER :
            return in_array($action, $this->user);
        case UserManager::EDITER :
            return in_array($action, $this->editer)
                || in_array($action, $this->user);
        case UserManager::ADMIN :
            return in_array($action, $this->admin)
                || in_array($action, $this->editer)
                || in_array($action, $this->user);
        }
        return false;
    }
}