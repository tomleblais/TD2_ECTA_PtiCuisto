<?php

require_once('src/controllers/allRecipes.php');
require_once('src/controllers/filteredRecipes.php');

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
            // TODO Erreur 404
        }
    } else {
        // TODO afficher la page de base
    }
} catch (Exception $e) {
    $errorMessage = $e->getMessage();

    require('templates/error.php');
}
