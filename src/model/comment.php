<?php

namespace Application\Model\Comment;

require_once('./src/lib/database.php');

use Application\Lib\Database\DatabaseConnection;

class Comment{
    public string $use_nickname;
    public string $com_content;
    public string $com_date;
}

class CommentModel {
    public function getComments(int $id) : array {
        $statement = DatabaseConnection::getConnection()->prepare(
            "SELECT USE_NICKNAME, COM_CONTENT, TO_CHAR(COM_DATE) AS COM_DATE FROM PC_WRITE
            JOIN PC_recette USING (COM_ID)
            JOIN PC_USER USING (USE_ID)
            WHERE REC_ID = ?"
        );

        $statement->execute([$id]);
        $comments = [];
        while (($row = $statement->fetch())) {
            $comment = new Comment();
            $comment->use_nickname = $row["use_nickname"];
            $comment->com_content = $row["com_content"];
            $comment->com_date = $row["com_date"];

            $comments[] = $comment;
        }

        return $comments;
    }
}
