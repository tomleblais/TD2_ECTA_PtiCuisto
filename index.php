<?php
session_start();

// Require -----------------------------------------------------------------
require_once('./src/lib/status.php');
require_once('./src/controllers/permission.php');

require_once('./src/controllers/homepage.php');
require_once('./src/controllers/connexion.php');
require_once('./src/controllers/login.php');
require_once('./src/controllers/allRecipes.php');
require_once('./src/controllers/filteredRecipes.php');
require_once('./src/controllers/viewRecipe.php');

require_once('./src/controllers/editer/addRecipe.php');
require_once('./src/controllers/editer/myRecipes.php');
require_once('./src/controllers/editer/updateRecipe.php');

require_once('./src/controllers/admin/checkRecipes.php');
require_once('./src/controllers/admin/updateEdito.php');
require_once('./src/controllers/admin/viewRecipeUncheck.php');
require_once('./src/controllers/admin/checkRecipe.php');

// Use application ----------------------------------------------------------
use Application\Lib\Status\Status;
use Application\Controllers\Permission\Permission;

use Application\Controllers\Homepage\Homepage;
use Application\Controllers\Connexion\Connexion;
use Application\Controllers\Login\Login;
use Application\Controllers\AllRecipes\AllRecipes;
use Application\Controllers\FilteredRecipes\FilteredRecipes;
use Application\Controllers\ViewRecipe\ViewRecipe;

use Application\Controllers\Editer\AddRecipe\AddRecipe;
use Application\Controllers\Editer\MyRecipes\MyRecipes;
use Application\Controllers\Editer\UpdateRecipe\UpdateRecipe;

use Application\Controllers\Admin\CheckRecipes\CheckRecipes;
use Application\Controllers\Admin\UpdateEdito\UpdateEdito;
use Application\Controllers\Admin\ViewRecipeUncheck\ViewRecipeUncheck;
use Application\Controllers\Admin\CheckRecipe\CheckRecipe;

// Execute --------------------------------------------------------------------
$type = isset($_SESSION['type']) ? $_SESSION['type'] : Status::USER;
$permission = new Permission($type);

try {
    if (isset($_GET['action']) && $_GET['action'] !== '') {
        // NONE -----------------------------------------------------------------------
        if ($type == Status::NONE) {
            throw new RangeException("Type d'utilisateur inconu, vous ne pouvez pas être John Doe !");
        }
        // USER -----------------------------------------------------------------------
        if ($_GET['action'] === 'allRecipes' && $permission->isAllowed('allRecipes')) {
            (new AllRecipes())->execute();
        } elseif ($_GET['action'] === 'filteredRecipes' && $permission->isAllowed('filteredRecipes')) {
            // TODO filteredRecipes
            (new FilteredRecipes())->execute("category", "jlk");
        } elseif ($_GET['action'] === 'viewRecipe' && $permission->isAllowed('viewRecipe')) {
            if (isset($_GET['id'])) {
                (new ViewRecipe())->execute(intval($_GET['id']));
            } else {
                throw new Exception('Aucun identifiant pour afficher une page');
            }
        } elseif ($_GET['action'] === 'connexion' && $permission->isAllowed('connexion')) {
            (new Connexion())->execute();
        } elseif ($_GET['action'] === 'login' && $permission->isAllowed('login')) {
            (new Login())->execute();
        }
        // EDITER ---------------------------------------------------------------------
        elseif ($_GET['action'] === 'addRecipe' && $permission->isAllowed('allRecipe')) {
            (new AddRecipe())->execute();
        } elseif ($_GET['action'] === 'myRecipes' && $permission->isAllowed('myRecipes')) {
            // TODO MyRecipes
            (new MyRecipes())->execute(0);
        } elseif ($_GET['action'] === 'updateRecipe' && $permission->isAllowed('updateRecipe')) {
            (new UpdateRecipe())->execute();
        }
        // ADMIN ----------------------------------------------------------------------
        elseif ($_GET['action'] === 'checkRecipes' && $permission->isAllowed('checkRecipes')) {
            (new CheckRecipes())->execute();
        } elseif ($_GET['action'] === 'updateEdito' && $permission->isAllowed('updateEdito')) {
            (new UpdateEdito())->execute();
        } elseif ($_GET['action'] === 'viewRecipeUncheck' && $permission->isAllowed('viewRecipeUncheck')) {
            if (isset($_GET['id'])) {
                (new ViewRecipeUncheck())->execute(intval($_GET['id']));
            } else {
                throw new Exception('Aucun identifiant pour afficher une page non validé');
            }
        } elseif ($_GET['action'] === 'checkRecipe' && $permission->isAllowed('checkRecipe')) {
            if (isset($_GET['id'])) {
                (new CheckRecipe())->execute(intval($_GET['id']));
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
