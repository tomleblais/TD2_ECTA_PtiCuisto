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

class Category {
    public int $cat_id;
    public string $cat_title;
}

class Ingredient {
    public int $ing_id;
    public string $ing_name;
}

class RecipeModel {
    public function getRecipes(int $valide = 1): array {
        $statement = DatabaseConnection::getConnection()->prepare(
            "SELECT rec_id, rec_title, rec_image, rec_summary FROM PC_RECIPE WHERE rec_valide = ?"
        );
        $statement->execute([$valide]);

        return $this->createRecipes($statement);
    }

    public function getLatestRecipes(): array {
        $statement = DatabaseConnection::getConnection()->prepare(
            "SELECT rec_id, rec_title, rec_summary, rec_image
            FROM PC_RECIPE
            WHERE rec_valide = 1
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

    public function getRecipeIngredients(int $id) : array {
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
        $recipe->rec_id = $id;

        $recipe->tags = $this->getTags($id);
        $recipe->ingredients= $this->getRecipeIngredients($id);
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
            "SELECT rec_title, rec_id, rec_summary, rec_image FROM PC_RECIPE WHERE use_id = ? AND rec_valide <> 2"
        );
        $statement->execute([$id]);

        return $this->createRecipes($statement);
    }

    public function checkRecipe(int $id) : bool {
        $statement = DatabaseConnection::getConnection()->prepare(
            "UPDATE PC_RECIPE SET rec_valide = 1, rec_registration_date = SYSDATE() WHERE rec_id = ?"
        );

        return !$statement->execute([$id]);
    }

    public function updateRecipePost(Recipe $recipe) {
        $statement = DatabaseConnection::getConnection()->prepare(
            "UPDATE PC_RECIPE SET rec_title = ?, rec_summary = ?, rec_valide = 0 WHERE rec_id = ?"
        );

        if (!$statement->execute([$recipe->rec_title, $recipe->rec_summary, $recipe->rec_id])) {
            throw new \Exception("La recette n'a pas été modifiée.");
        }
    }

    public function addRecipe(Recipe $recipe) {
        $statement = DatabaseConnection::getConnection()->prepare(
            "INSERT INTO PC_RECIPE (cat_id, rec_title, rec_summary, rec_image, rec_creation_date, rec_valide) VALUES (?, ?, ?, ?, sysdate, 0)"
        );

        if (!$statement->execute([$recipe->rec_title, $recipe->rec_summary, $recipe->rec_id, $recipe->rec_image])) {
            throw new \Exception("La recette n'a pas été insérée.");
        }
    }

    public function deleteRecipe(int $id) {
        $statement = DatabaseConnection::getConnection()->prepare(
            "UPDATE PC_RECIPE SET rec_valide = 2 WHERE rec_id = ?"
        );

        if (!$statement->execute([$id])) {
            throw new \Exception("La recete n'a pas été supprimée.");
        }
    }

    private function createRecipes($statement): array {
        $recipes = [];

        while (($row = $statement->fetch())) {
            $recipe = new Recipe();
            $recipe->rec_id = $row["rec_id"];
            $recipe->rec_title = $row["rec_title"];
            $recipe->rec_summary = $row["rec_summary"];
            $recipe->rec_image = $row["rec_image"];

            $recipes[] = $recipe;
        }

        return $recipes;
    }

    public function getCategories() : array {
        $statement = DatabaseConnection::getConnection()->prepare(
            "SELECT cat_id, cat_title FROM PC_CATEGORY"
        );
        $statement->execute();

        $categories = [];
        while (($row = $statement->fetch())) {
            $category = new Category();
            $category->cat_id = $row["cat_id"];
            $category->cat_title = $row["cat_title"];

            $categories[] = $category;
        }

        return $categories;
    }

    public function getRecipesByCategory(int $category) : array {
        $statement = DatabaseConnection::getConnection()->prepare(
            "SELECT rec_id, rec_title, rec_summary, rec_image FROM PC_RECIPE WHERE cat_id = ?"
        );
        $statement->execute([$category]);

        return $this->createRecipes($statement);
    }

    public function getIngredients() : array {
        $statement = DatabaseConnection::getConnection()->prepare(
            "SELECT ing_id, ing_name FROM PC_INGREDIENT"
        );
        $statement->execute();

        $ingredients = [];
        while (($row = $statement->fetch())) {
            $ingredient = new Ingredient();
            $ingredient->ing_id = $row["ing_id"];
            $ingredient->ing_name = $row["ing_name"];

            $ingredients[] = $ingredient;
        }

        return $ingredients;
    }

    public function getRecipesByIngredient(int $ingredient) : array {
        $statement = DatabaseConnection::getConnection()->prepare(
            "SELECT rec_id, rec_title, rec_summary, rec_image FROM PC_RECIPE WHERE rec_id IN (
                SELECT rec_id FROM PC_CONTAIN WHERE ing_id = ?   
            )"
        );
        $statement->execute([$ingredient]);

        return $this->createRecipes($statement);
    }
}