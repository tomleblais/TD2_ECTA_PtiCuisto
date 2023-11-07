<?php

namespace Application\Model\User\ViewRecipe;

require_once('src/lib/database.php');
require_once('src/lib/recipe.php');

use Application\Lib\Database\DatabaseConnection;
use Application\Lib\Recipe\Recipe;

class Comment{
        public string $use_nickname;
        public string $com_content;
        public string $com_date;
}

class ViewRecipeModel
{
    
    private int $id;

    public function __construct(int $id) {
        $this->id = $id;
    }
    
    public function getComments() : array {
        $statement = DatabaseConnection::getConnection()->prepare(
            "SELECT USE_NICKNAME, COM_CONTENT, COM_DATE FROM PC_WRITE
            JOIN PC_recette USING (COM_ID)
            JOIN PC_USER USING (USE_ID)
            WHERE REC_ID = ?"
        );

        $statement->execute([$this->id]);
        $comments = [];
        while (($row = $statement->fetch())) {
            $comment= new Comment();
            $comment->use_nickname = $row["use_nickname"];
            $comment->com_content = $row["com_content"];
            $comment->com_date = $row["com_date"];

            $comments[] = $comment;
        }

        return $comment;
    }

    public function getRecipe() : Recipe {
        $statement = DatabaseConnection::getConnection()->prepare(
            "SELECT tag_name FROM PC_TAG
            JOIN PC_LABEL USING (TAG_ID)
            JOIN PC_RECIPE USING (REC_ID)
            WHERE REC_ID = ?"

            
        );
        $statement->execute([$this->id]);
        $tags = [];
        while (($row = $statement->fetch())) {
            $tag_name= $row["tag_name"];
            $tags[] += $tag_name;
        }

        $statement2 = DatabaseConnection::getConnection()->prepare(
            "SELECT rec_title, rec_image, rec_summary, rec_creation_date, rec_modification_date, use_nickname FROM PC_WRITE
            JOIN PC_recette USING (COM_ID)
            JOIN PC_USER USING (USE_ID)
            WHERE REC_ID = ?"

            
        );
        $statement2->execute([$this->id]);
        $recette= new Recipe;
        while (($row = $statement2->fetch())) {
            $recette->rec_title = $row["rec_title"];
            $recette->rec_image = $row["rec_image"];
            $recette->rec_summary = $row["rec_summary"];
            $recette->rec_creation_date = $row["rec_creation_date"];
            $recette->rec_modification_date = $row["rec_modification_date"];
            $recette->use_nickname = $row["use_nickname"];
        }
        $recette->tags= $tags;

        return $recette;
    }
}

