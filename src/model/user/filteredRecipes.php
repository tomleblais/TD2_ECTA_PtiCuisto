<?php

namespace Application\Model\User\FilteredRecipes;

require_once('src/lib/database.php');
require_once('src/lib/recipe.php');

use Application\Lib\Database\DatabaseConnection;
use Application\Lib\Recipe\Recipe;

class FilteredRecipesRepository {
    private DatabaseConnection $connection;

    public function __construct(DatabaseConnection $connection) {
        $this->connection = $connection;
    }

    private function createRecipes($statement): array {
        $recipes = [];

        while (($row = $statement->fetch())) {
            $recipe = new Recipe();
            $recipe->rec_id = $row["rec_id"];
            $recipe->rec_title = $row["rec_title"];

            $recipes[] = $recipe;
        }

        return $recipes;
    }

    public function getFilteredRecipesByCategory(int $category) : array {
        $statement = $this->connection->getConnection()->prepare(
            "SELECT rec_id, rec_title FROM PC_RECIPE WHERE cat_id = ?"
        );
        $statement->execute([$category]);

        return $this->createRecipes($statement);
    }

    public function getFilteredRecipesByTitle(string $title) : array {
        $statement = $this->connection->getConnection()->prepare(
            "SELECT rec_id, rec_title FROM pc_recipe WHERE rec_title = ?"
        );
        $statement->execute([$title]);

        return $this->createRecipes($statement);
    }

    public function getFilteredRecipesByIngredient(int $ingredient) : array {
        $statement = $this->connection->getConnection()->prepare(
            "SELECT rec_id, rec_title FROM pc_recipe WHERE rec_id = (
                SELECT rec_id FROM pc_contain WHERE ing_id = ?   
            )"
        );
        $statement->execute([$ingredient]);

        return $this->createRecipes($statement);
    }
}