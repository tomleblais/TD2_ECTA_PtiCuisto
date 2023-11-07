<?php

namespace Application\Model\Recipe;

require_once('src/lib/database.php');

use Application\Lib\Database\DatabaseConnection;

class Recipe {
    public int $rec_id;
    public string $rec_title;
    public string $rec_image;
    public string $rec_summary;
    public string $rec_creation_date;
    public string $rec_modification_date;
    public string $use_nickname;
    public array $tags;
}

class RecipeModel {
    public function getRecipes(): array {
        // Make the query
        $statement = DatabaseConnection::getConnection()->query(
            "SELECT rec_id, rec_title FROM PC_RECIPE WHERE rec_valide = TRUE"
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

    public function getRecipe(int $id) : Recipe {
        $statement = DatabaseConnection::getConnection()->prepare(
            "SELECT tag_name FROM PC_TAG
            JOIN PC_LABEL USING (TAG_ID)
            JOIN PC_RECIPE USING (REC_ID)
            WHERE REC_ID = ?"            
        );

        $statement->execute([$id]);
        $tags = [];

        while (($row = $statement->fetch())) {
            $tag_name= $row["tag_name"];
            $tags = $tag_name;
        }

        $statement2 = DatabaseConnection::getConnection()->prepare(
            "SELECT rec_title, rec_image, rec_summary, rec_creation_date, rec_modification_date, use_nickname FROM PC_WRITE
            JOIN PC_recette USING (COM_ID)
            JOIN PC_USER USING (USE_ID)
            WHERE REC_ID = ?"
        );

        $statement2->execute([$id]);
        $recette = new Recipe();
        echo $statement2->fetch() . "aaaaaa";
        while (($row = $statement2->fetch())) {
            $recette->rec_title = $row["rec_title"];
            $recette->rec_image = $row["rec_image"];
            $recette->rec_summary = $row["rec_summary"];
            $recette->rec_creation_date = $row["rec_creation_date"];
            $recette->rec_modification_date = $row["rec_modification_date"];
            $recette->use_nickname = $row["use_nickname"];
            echo $row;
        }

        return $recette;
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
        $statement = DatabaseConnection::getConnection()->prepare(
            "SELECT rec_id, rec_title FROM PC_RECIPE WHERE cat_id = ?"
        );
        $statement->execute([$category]);

        return $this->createRecipes($statement);
    }

    public function getFilteredRecipesByTitle(string $title) : array {
        $statement = DatabaseConnection::getConnection()->prepare(
            "SELECT rec_id, rec_title FROM pc_recipe WHERE rec_title = ?"
        );
        $statement->execute([$title]);

        return $this->createRecipes($statement);
    }

    public function getFilteredRecipesByIngredient(int $ingredient) : array {
        $statement = DatabaseConnection::getConnection()->prepare(
            "SELECT rec_id, rec_title FROM pc_recipe WHERE rec_id = (
                SELECT rec_id FROM pc_contain WHERE ing_id = ?   
            )"
        );
        $statement->execute([$ingredient]);

        return $this->createRecipes($statement);
    }
}