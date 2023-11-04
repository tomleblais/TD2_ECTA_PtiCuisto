<?php
// http://localhost/TD2_ECTA_PTICUISTOT/index.php

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

// Use application ----------------------------------------------------------
use Application\Controllers\Homepage\Homepage;
use Application\Controllers\Connexion\Connexion;

use Application\Controllers\User\AllRecipes\AllRecipes;
use Application\Controllers\User\FilteredRecipes\FilteredRecipes;
use Application\Controllers\User\ViewRecipe\ViewRecipe;

use Application\Controllers\Editer\AddRecipe\AddRecipe;
use Application\Controllers\Editer\MyRecipes\MyRecipes;
use Application\Controllers\Editer\UpdateRecipe\UpdateRecipe;

use Application\Controllers\Admin\CheckRecipes\CheckRecipes;
use Application\Controllers\Admin\UpdateEdito\UpdateEdito;


// Execute --------------------------------------------------------------------
define('ERROR_404', 'templates/errors/error404.php');

try {
    if (isset($_GET['action']) && $_GET['action'] !== '') {
        if ($_GET['action'] === 'connexion') {
            (new Connexion())->execute();
        }
        // USER -----------------------------------------------------------------------
        if (true) { // TODO USER ou EDITER ou ADMIN
            if ($_GET['action'] === 'allRecipes') {
                (new AllRecipes())->execute();
            } elseif ($_GET['action'] === 'filteredRecipes') {
                // TODO filteredRecipes
                (new FilteredRecipes())->execute("category", "jlk");
            } elseif ($_GET['action'] === 'viewRecipe') {
                // TODO view recipe
                (new ViewRecipe())->execute(1);
            } elseif (false) {  // TODO USER
                require(ERROR_404);
            }
        }
        // EDITER ----------------------------------------------------------------------
        if (true) { // TODO editer ou admin
            if ($_GET['action'] === 'addRecipe') {
                (new AddRecipe())->execute();
            } elseif ($_GET['action'] === 'myRecipes') {
                (new MyRecipes())->execute();
            } elseif ($_GET['action'] === 'updateRecipe') {
                (new UpdateRecipe())->execute();
            } elseif (false) {  // TODO EDITER
                require(ERROR_404);
            }
        }
        // ADMIN ------------------------------------------------------------------------
        if (true) { // TODO admin
            if ($_GET['action'] === 'checkRecipes') {
                (new CheckRecipes())->execute();
            } elseif ($_GET['action'] === 'updateEdito') {
                (new UpdateEdito())->execute();
            } elseif (false) { // TODO ADMIN
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
