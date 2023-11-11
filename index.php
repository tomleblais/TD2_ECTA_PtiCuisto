<?php
session_start();

// Require -----------------------------------------------------------------
require_once('./src/model/user.php');
require_once('./src/controllers/permission.php');

require_once('./src/controllers/recipe.php');
require_once('./src/controllers/user.php');

require_once('./src/controllers/homepage.php');
require_once('./src/controllers/admin/updateEdito.php');

// Use application ----------------------------------------------------------
use Application\Model\User\UserManager;
use Application\Controllers\Permission\Permission;

use Application\Controllers\Recipe\Recipe_c;
use Application\Controllers\User\User_c;

use Application\Controllers\Homepage\Homepage;
use Application\Controllers\Admin\UpdateEdito\UpdateEdito;

// Execute --------------------------------------------------------------------
$id = isset($_GET['id']) ? intval($_GET['id']) : null;
$type = isset($_SESSION['type']) ? $_SESSION['type'] : UserManager::USER;
$permission = new Permission($id, $type);

try {
    if (isset($_GET['action']) && $_GET['action'] !== '') {
        // NONE -----------------------------------------------------------------------
        if ($type == UserManager::NONE) {
            throw new RangeException("Type d'utilisateur inconu, vous ne pouvez pas être John Doe !");
        }
        // USER -----------------------------------------------------------------------
        if ($_GET['action'] === 'allRecipes' && $permission->isAllowed('allRecipes')) {
            (new Recipe_c())->allRecipes();
        } elseif ($_GET['action'] === 'filteredRecipes' && $permission->isAllowed('filteredRecipes')) {
            // TODO filteredRecipes
        } elseif ($_GET['action'] === 'showRecipe' && $permission->isAllowed('showRecipe')) {
            if (isset($_GET['id'])) {
                $id = intval($_GET['id']);
                (new Recipe_c())->showRecipe($id, $permission->isAllowed('updateRecipe', $id));
            } else {
                throw new Exception('Aucun identifiant pour afficher une page');
            }
        } elseif ($_GET['action'] === 'connexion' && $permission->isAllowed('connexion')) {
            (new User_c())->connexion();
        } elseif ($_GET['action'] === 'login' && $permission->isAllowed('login')) {
            (new User_c())->login();
        }
        // EDITER ---------------------------------------------------------------------
        elseif ($_GET['action'] === 'addRecipe' && $permission->isAllowed('allRecipe')) {
            (new Recipe_c())->addRecipe();
        } elseif ($_GET['action'] === 'myRecipes' && $permission->isAllowed('myRecipes')) {
            if (isset($_SESSION["id"])) {
                (new Recipe_c())->myRecipes($_SESSION["id"]);
            } else {
                throw new Exception("L'ID n'est pas déffinie");
            }
        } elseif ($_GET['action'] === 'updateRecipe' && $permission->isAllowed('updateRecipe')) {
            if (isset($_SESSION["id"])) {
                (new Recipe_c())->updateRecipe(intval($_GET['id']));
            } else {
                throw new Exception("L'ID n'est pas déffinie");
            }
        } elseif ($_GET['action'] === 'updateRecipePost') {
            if (isset($_GET['id'])) {
                $id = intval($_GET['id']);
                if ($permission->isAllowed('updateRecipePost', $id)) {
                    (new Recipe_c())->updateRecipePost($id);
                } else {
                    require('./templates/errors/error404.php');
                }
            } else {
                throw new Exception('Aucun identifiant pour afficher une page');
            }
        } elseif ($_GET['action'] === 'deleteRecipe') {
            if (isset($_GET['id'])) {
                $id = intval($_GET['id']);
                if ($permission->isAllowed('deleteRecipe', $id)) {
                    (new Recipe_c())->deleteRecipe($id);
                } else {
                    require('./templates/errors/error404.php');
                }
            } else {
                throw new Exception('Aucun identifiant pour supprimer la recette');
            }
        } elseif ($_GET['action'] === 'logout' && $permission->isAllowed('logout')) {
            (new User_c())->logout();
        }
        // ADMIN ----------------------------------------------------------------------
        elseif ($_GET['action'] === 'checkRecipes' && $permission->isAllowed('checkRecipes')) {
            (new Recipe_c())->checkRecipes();
        } elseif ($_GET['action'] === 'updateEdito' && $permission->isAllowed('updateEdito')) {
            (new UpdateEdito())->execute();
        } elseif ($_GET['action'] === 'showRecipeUncheck' && $permission->isAllowed('showRecipeUncheck')) {
            if (isset($_GET['id'])) {
                (new Recipe_c())->showRecipeUncheck(intval($_GET['id']));
            } else {
                throw new Exception('Aucun identifiant pour afficher une page non validé');
            }
        } elseif ($_GET['action'] === 'checkRecipe' && $permission->isAllowed('checkRecipe')) {
            if (isset($_GET['id'])) {
                (new Recipe_c())->checkRecipe(intval($_GET['id']));
            } else {
                throw new Exception('Aucun identifiant pour validé la page !');
            }
        } else {
            require('./templates/errors/error404.php');
        }
    } else {
        (new Homepage())->execute();
    }
} catch (Exception $exception) {
    $errorMessage = $exception->getMessage();

    require('./templates/errors/error.php');
}
