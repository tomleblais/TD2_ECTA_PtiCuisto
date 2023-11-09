<?php

namespace Application\Controllers\Permission;

require_once('./src/model/user.php');

use Application\Model\User\UserManager;

class Permission {
    private int $type;
    private $user;
    private $editer;
    private $admin;

    public function __construct(int $type) {
        $this->type = $type;

        $this->user = [
            "homepage",
            "connexion",
            "login",
            "allRecipes",
            "filteredRecipes",
            "viewRecipe"
        ];

        $this->editer = [
            "addRecipe",
            "myRecipes",
            "modifyRecipe"
        ];

        $this->admin = [
            "checkRecipes",
            "viewRecipeUncheck",
            "checkRecipe",
            "updateEdito"
        ];
    }

    public function isAllowed(string $action): bool {
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