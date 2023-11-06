<?php

namespace Application\Lib\Status;

require_once("./src/lib/database.php");

use Application\Lib\Database\DatabaseConnection;

class Status {
    public static const NONE = 0;
    public static const USER = 1;
    public static const EDITER = 2;
    public static const ADMIN = 3;

    public static function getType(int $id): int {
        $statement = DatabaseConnection::getConnection()->prepare(
            "SELECT uty_id FROM PC_USER WHERE use_id = ?"
        );
        $statement->execute([$id]);

        return self::numberToConst($statement->fetch()["uty_id"]);
    }

    private static function numberToConst(int $number): int {
        switch ($number) {
        case 1:
            return self::USER;
        case 2:
            return self::EDITER;
        case 3:
            return self::ADMIN;
        default:
            return self::NONE;
        }
    }
}
