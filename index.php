<?php

require_once('src/controllers/homepage.php');
require_once('src/controllers/allRecipes.php');
require_once('src/controllers/filteredRecipes.php');

use Application\Controllers\Homepage\Homepage;
use Application\Controllers\AllRecipes\AllRecipes;
use Application\Controllers\FilteredRecipes\FilteredRecipes;

try {
    if (isset($_GET['action']) && $_GET['action'] !== '') {
        if ($_GET['action'] === 'allRecipes') {
            (new AllRecipes())->execute();
        } elseif ($_GET['action'] === 'filteredRecipes') {
            // TODO filteredRecipes

            /*if (isset($_GET['id']) && $_GET['id'] > 0) {
                $identifier = $_GET['id'];

                (new AddComment())->execute($identifier, $_POST);
            } else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }*/
        } else {
            require('templates/error404.php');
        }
    } else {
        (new Homepage())->execute();
    }
} catch (Exception $e) {
    $errorMessage = $e->getMessage();

    require('templates/error.php');
}
