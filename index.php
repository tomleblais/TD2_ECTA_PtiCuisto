<?php
session_start();

// Require -----------------------------------------------------------------
require_once('src/controllers/homepage.php');
require_once('src/controllers/connexion.php');

require_once('src/controllers/user/allRecipes.php');
require_once('src/controllers/user/filteredRecipes.php');
require_once('src/controllers/user/viewRecipe.php');

require_once('src/controllers/editer/addRecipe.php');
require_once('src/controllers/editer/myRecipes.php');
require_once('src/controllers/editer/updateRecipe.php');

require_once('src/controllers/admin/checkRecipes.php');
require_once('src/controllers/admin/updateEdito.php');

require_once('src/lib/status.php');

// Use application ----------------------------------------------------------
use Application\Controllers\Homepage\Homepage;
use Application\Controllers\Connection\Login;

use Application\Controllers\User\AllRecipes\AllRecipes;
use Application\Controllers\User\FilteredRecipes\FilteredRecipes;
use Application\Controllers\User\ViewRecipe\ViewRecipe;

use Application\Controllers\Editer\AddRecipe\AddRecipe;
use Application\Controllers\Editer\MyRecipes\MyRecipes;
use Application\Controllers\Editer\UpdateRecipe\UpdateRecipe;

use Application\Controllers\Admin\CheckRecipes\CheckRecipes;
use Application\Controllers\Admin\UpdateEdito\UpdateEdito;

use Application\Lib\Status\Status;

// Execute --------------------------------------------------------------------
define('ERROR_404', 'templates/errors/error404.php');
$type = (isset($_SESSION['type'])) ? $_SESSION['type'] : Status::USER;

try {
    if (isset($_GET['action']) && $_GET['action'] !== '') {
        if ($_GET['action'] === 'connexion') {
            (new Login())->execute();
        }
        // NONE -----------------------------------------------------------------------
        if ($type == Status::NONE) {
            throw new RangeException("Type d'utilisateur inconu, vous ne pouvez pas être John Doe !");
        }
        // USER -----------------------------------------------------------------------
        if ($type >= Status::USER) {
            if ($_GET['action'] === 'allRecipes') {
                (new AllRecipes())->execute();
            } elseif ($_GET['action'] === 'filteredRecipes') {
                // TODO filteredRecipes
                (new FilteredRecipes())->execute("category", "jlk");
            } elseif ($_GET['action'] === 'viewRecipe') {
                if (isset($_GET['id'])) {
                    (new ViewRecipe())->execute($_GET['id']);
                } else {
                    throw new Exception('Aucun identifiant pour afficher une page');
                }
            } elseif ($type == Status::USER) {
                require(ERROR_404);
            }
        }
        // EDITER ----------------------------------------------------------------------
        if ($type >= Status::EDITER) {
            if ($_GET['action'] === 'addRecipe') {
                (new AddRecipe())->execute();
            } elseif ($_GET['action'] === 'myRecipes') {
                (new MyRecipes())->execute();
            } elseif ($_GET['action'] === 'updateRecipe') {
                (new UpdateRecipe())->execute();
            } elseif ($type == Status::EDITER) {
                require(ERROR_404);
            }
        }
        // ADMIN ------------------------------------------------------------------------
        if ($type == Status::ADMIN) {
            if ($_GET['action'] === 'checkRecipes') {
                (new CheckRecipes())->execute();
            } elseif ($_GET['action'] === 'updateEdito') {
                (new UpdateEdito())->execute();
            } else {
                require(ERROR_404);
            }
        }
    } else {
        (new Homepage())->execute();
    }
} catch (Exception $exception) {
    $errorMessage = $exception->getMessage();

    require('templates/errors/error.php');
}
