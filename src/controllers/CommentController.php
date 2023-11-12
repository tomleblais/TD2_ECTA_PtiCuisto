<?php

namespace Application\Controllers\CommentController;

require_once('./src/models/RecipeModel.php');
require_once('./src/models/CommentModel.php');

use Application\Model\CommentModel\Comment;
use Application\Model\CommentModel\CommentManager;

class CommentController {

    public function writeCommentPost(int $id, int $modify) {
        
        if (!isset($_POST['content'])) {
            return "Votre commentaire ne peut pas être vide.";
        } elseif (!isset($_POST['nickname'])) {
            return "Nom d'utilisateur manquant.";
        }
        $comment = new Comment();
        
        $comment->rec_id = $id;
        $comment->use_nickname = $_POST['nickname'];
        $comment->com_content = htmlspecialchars($_POST['content']);

        if (empty($comment->com_content)) {
            return "Votre commentaire ne peut pas être vide.";
        } elseif (mb_strlen($comment->com_content, 'UTF-8') > 4096) {
            return "Votre commentaire ne doit pas dépasser 4096 caractères.";
        }

        (new CommentManager())->insertComment($comment);

        header("Location: ./index.php?action=recipeDetails&id=$id");
    }
}
