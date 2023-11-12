<?php

namespace Application\Model\CommentModel;
use Exception;

require_once('./src/lib/database.php');

use Application\Lib\Database\DatabaseConnection;

class Comment {
    public int $rec_id;
    public string $use_nickname;
    public string $com_content;
    public string $com_date;
}

class CommentManager {
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
            $comment->rec_id = $id;
            $comment->use_nickname = $row["USE_NICKNAME"];
            $comment->com_content = $row["COM_CONTENT"];
            $comment->com_date = $row["COM_DATE"];

            array_push($comments, $comment);
        }
        return $comments;
    }

    public function insertComment(Comment $comment) {
        $com_id = 0;

        $statement = DatabaseConnection::getConnection()->prepare(
            "INSERT INTO PC_COMMENT (COM_CONTENT, COM_DATE)
            VALUES (?, NOW())"
        );
        $statement->execute([$comment->com_content]);
        
        $statement = DatabaseConnection::getConnection()->prepare(
            "SELECT max(COM_ID) AS COM_ID
            FROM PC_COMMENT"
        );
        $statement->execute();
        $res = $statement->fetch();
        $com_id = intval($res["COM_ID"]);
        
        $statement = DatabaseConnection::getConnection()->prepare(
            "INSERT INTO PC_WRITE (USE_ID, REC_ID, COM_ID)
            VALUES (
                (
                    SELECT USE_ID
                    FROM PC_USER
                    WHERE USE_NICKNAME = ?
                ),
                ?,
                ?
            )"
        );
        $statement->execute([$comment->use_nickname, $comment->rec_id, $com_id]);
    }
}
