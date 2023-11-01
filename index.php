<?php
// http://localhost/TD2_ECTA_PTICUISTOT/index.php

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
            (new FilteredRecipes())->execute("category", "jlk");
        } else {
            require('templates/errors/error404.php');
        }
    } else {
        (new Homepage())->execute();
    }
} catch (Exception $exception) {
    $errorMessage = $exception->getMessage();

    require('templates/errors/error.php');
}
