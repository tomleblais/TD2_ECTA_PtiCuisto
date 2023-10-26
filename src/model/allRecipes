<?php

namespace Application\Model\AllRecipes;

require_once('src/lib/database.php');
require_once('src/lib/Recipe.php');

use Application\Lib\Database\DatabaseConnection;
use Application\Lib\Recipe\Recipe;

class AllRecipeRepository {
    private DatabaseConnection $connection;

    public function __construct(DatabaseConnection $connection) {
        $this->connection = $connection;
    }

    public function getRecipes(): array {
        // Make the query
        $statement = $this->connection->getConnection()->query(
            "SELECT rec_id, rec_title FROM pc_recipe"
        );

        // Take values
        $recipes = [];

        while (($row = $statement->fetch())) {
            $recipe = new Recipe();
            $recipe->rec_id = $row["rec_id"];
            $recipe->rec_title = $row["rec_title"];

            $recipes[] = $recipe;
        }

        return $recipes;
    }
}