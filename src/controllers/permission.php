<?php

namespace Application\Controllers\Permission;

require_once('./src/lib/status.php');

use Application\Lib\Status\Status;

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
            "updateRecipe"
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
        case Status::USER :
            return in_array($action, $this->user);
        case Status::EDITER :
            return in_array($action, $this->editer)
                || in_array($action, $this->user);
        case Status::ADMIN :
            return in_array($action, $this->admin)
                || in_array($action, $this->editer)
                || in_array($action, $this->user);
        }
        return false;
    }
}