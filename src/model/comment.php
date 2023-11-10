<?php

namespace Application\Model\Comment;
use Exception;

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
            "SELECT USE_NICKNAME, COM_CONTENT, COM_DATE FROM PC_WRITE
            JOIN PC_USER USING (USE_ID)
            JOIN PC_COMMENT USING (COM_ID)
            WHERE REC_ID = ?"
        );
        $statement->execute([$id]);
        $comments = [];
        while ($row = $statement->fetch()) {
            $comment = new Comment();
            $comment->use_nickname = 
            $row["USE_NICKNAME"];
            $comment->com_content = $row["COM_CONTENT"];
            $comment->com_date = $row["COM_DATE"];

            array_push($comments, $comment);
        }
        return $comments;
    }
}
