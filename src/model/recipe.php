<?php

namespace Application\Model\Recipe;

require_once('./src/lib/database.php');

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
    public array $ingredients;
    public int $use_id;
}

class RecipeModel {
    public function getRecipes(int $valide = 1): array {
        $statement = DatabaseConnection::getConnection()->prepare(
            "SELECT rec_id, rec_title, rec_image FROM PC_RECIPE WHERE rec_valide = ?"
        );
        $statement->execute([$valide]);

        $recipes = [];
        while (($row = $statement->fetch())) {
            $recipe = new Recipe();
            $recipe->rec_id = $row["rec_id"];
            $recipe->rec_title = $row["rec_title"];
            $recipe->rec_image = $row["rec_image"];

            $recipes[] = $recipe;
        }

        return $recipes;
    }

    public function getLatestRecipes(): array {
        $statement = DatabaseConnection::getConnection()->prepare(
            "SELECT rec_id, rec_title, rec_summary, rec_image
            FROM PC_RECIPE
            ORDER BY rec_creation_date DESC
            LIMIT 3"
        );
        
        if (!$statement->execute()) {
            throw new \Exception("Echec de la requête pour récupérer les recettes de l'edito.");
        }

        $recipes = [];
        while (($row = $statement->fetch())) {
            $recipe = new Recipe();
            $recipe->rec_id = $row["rec_id"];
            $recipe->rec_title = $row["rec_title"];
            $recipe->rec_summary = substr($row["rec_summary"], 0, 300) . '...';
            $recipe->rec_image = $row["rec_image"];

            $recipes[] = $recipe;
        }

        return $recipes;
    }

    public function getTags(int $id) : array {
        $statement = DatabaseConnection::getConnection()->prepare(
            "SELECT tag_name FROM PC_TAG JOIN PC_LABEL USING (tag_id) WHERE rec_id = ?"
        );
        $statement->execute([$id]);

        $tags= [];
        while ($row = $statement->fetch()) {
            array_push($tags, $row["tag_name"]);
        }

        return $tags;
    }

    public function getIngredients(int $id) : array {
        $statement = DatabaseConnection::getConnection()->prepare(
            "SELECT ing_name FROM PC_CONTAIN JOIN PC_INGREDIENT USING (ing_id) WHERE rec_id = ?"
        );
        $statement->execute([$id]);

        $ingredients= [];
        while ($row = $statement->fetch()) {
            array_push($ingredients, $row["ing_name"]);
        }

        return $ingredients;
    }

    public function getRecipe(int $id) : Recipe {
        $statement = DatabaseConnection::getConnection()->prepare(
            "SELECT rec_title, rec_image, rec_summary, rec_creation_date, rec_modification_date, use_nickname FROM PC_RECIPE
            JOIN PC_USER USING (USE_ID)
            WHERE rec_id = ?"
        );
        $statement->execute([$id]);
        
        if (!($row = $statement->fetch())) {
            throw new \Exception("La recette n'a pas pu être trouvée !");
        }
    
        $recipe = new Recipe();
        $recipe->rec_title = $row["rec_title"];
        $recipe->rec_image = $row["rec_image"];
        $recipe->rec_summary = $row["rec_summary"];
        $recipe->rec_creation_date = $row["rec_creation_date"];
        $recipe->rec_modification_date = $row["rec_modification_date"];
        $recipe->use_nickname = $row["use_nickname"];
        $recipe->tags = $this->getTags($id);
        $recipe->ingredients= $this->getIngredients($id);
        return $recipe;
    }

    public function getAutor(int $id) : int {
        $statement = DatabaseConnection::getConnection()->prepare(
            "SELECT use_id FROM PC_RECIPE WHERE rec_id = ?"
        );
        $statement->execute([$id]);

        if (!($row = $statement->fetch())) {
            throw new \Exception("L'auteur n'a pas pu être trouvée !");
        }

        return $row["use_id"];
    }

    public function getMyRecipes(int $id) : array {
        $statement = DatabaseConnection::getConnection()->prepare(
            "SELECT rec_title, rec_id FROM PC_RECIPE WHERE use_id = ? AND rec_valide <> 2"
        );
        $statement->execute([$id]);

        $recipes = [];
        while (($row = $statement->fetch())) {
            $recipe = new Recipe();
            $recipe->rec_id = $row["rec_id"];
            $recipe->rec_title = $row["rec_title"];

            $recipes[] = $recipe;
        }

        return $recipes;
    }

    public function checkRecipe(int $id) : bool {
        $statement = DatabaseConnection::getConnection()->prepare(
            "UPDATE PC_RECIPE SET rec_valide = 1, rec_registration_date = SYSDATE() WHERE rec_id = ?"
        );

        return !$statement->execute([$id]);
    }

    public function updateRecipePost(Recipe $recipe) {
        $statement = DatabaseConnection::getConnection()->prepare(
            "UPDATE PC_RECIPE SET rec_title = ?, rec_summary = ? WHERE rec_id = ?"
        );

        if (!$statement->execute([$recipe->rec_title, $recipe->rec_summary, $recipe->rec_id])) {
            throw new \Exception("La recette n'a pas était modifiée.");
        }
    }

    public function deleteRecipe(int $id) {
        $statement = DatabaseConnection::getConnection()->prepare(
            "UPDATE PC_RECIPE SET rec_valide = 2 WHERE rec_id = ?"
        );

        if (!$statement->execute([$id])) {
            throw new \Exception("La recete n'a pas était supprimée.");
        }
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