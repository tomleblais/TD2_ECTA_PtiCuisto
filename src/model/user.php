<?php

namespace Application\Model\User;

require_once('./src/lib/database.php');

use Application\Lib\Database\DatabaseConnection;

class User {
    public int $use_id;
    public string $use_nickname;
    public string $use_email;
    public string $use_firstname;
    public string $use_lastname;
    public string $use_password;
    public int $uty_id;
    public int $ust_id;
}

class UserManager {
    public const NONE = 0;
    public const USER = 1;
    public const EDITER = 2;
    public const ADMIN = 3;

    public static function getType(int $id): int {
        $statement = DatabaseConnection::getConnection()->prepare(
            "SELECT uty_id FROM PC_USER WHERE use_id = ?"
        );
        $statement->execute([$id]);

        return self::numberToConst($statement->fetch()["uty_id"]);
    }

    public function getUsers(): array {
        $statement = DatabaseConnection::getConnection()->prepare(
            "SELECT USE_ID, USE_NICKNAME, USE_EMAIL, USE_FIRSTNAME, USE_LASTNAME, USE_PASSWORD, UTY_ID, UST_ID
            FROM PC_USER
            JOIN PC_USER_STATUS USING (UST_ID)"
        );
        $statement->execute();

        $users = [];

        while (($row = $statement->fetch())) {
            $user = new User();

            $user->use_id = intval($row["USE_ID"]);
            $user->use_nickname = $row["USE_NICKNAME"];
            $user->use_email = $row["USE_EMAIL"];
            $user->use_firstname = $row["USE_FIRSTNAME"];
            $user->use_lastname = $row["USE_LASTNAME"];
            $user->use_password = $row["USE_PASSWORD"];
            $user->uty_id = intval($row["UTY_ID"]);
            $user->ust_id = intval($row["UST_ID"]);

            $users[] = $user;
        }

        return $users;
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

    public static function setHeader(int $type) {
        switch ($type) {
        case self::EDITER:
            $_SESSION['header'] = './templates/headers/editer.php';
            break;
        case self::ADMIN:
            $_SESSION['header'] = './templates/headers/admin.php';
            break;
        default:
            $_SESSION['header'] = './templates/headers/user.php';
        }
    }

    public function login($email, $password): int {
        $statement = DatabaseConnection::getConnection()->prepare(
            "SELECT COUNT(*) AS USER_COUNT FROM PC_USER WHERE USE_EMAIL = ? AND USE_PASSWORD = ? AND UST_ID = 1"
        );
        $statement->execute([$email, $password]);
        $result = $statement->fetch();

        if ($result["USER_COUNT"] != 1) {
            return -1;
        } else {
            $statement = DatabaseConnection::getConnection()->prepare(
                "SELECT USE_ID FROM PC_USER WHERE USE_EMAIL = ? AND USE_PASSWORD = ?"
            );
            $statement->execute([$email, $password]);
            $result = $statement->fetch();

            return $result["USE_ID"];
        }
    }

    public function checkEmail(string $email): bool {
        $statement = DatabaseConnection::getConnection()->prepare(
            "SELECT * FROM PC_USER WHERE use_email = ?"
        );
        
        if (!$statement->execute([$email])) {
            throw new \Exception("Echec de la requête pour récupérer les recettes de l'edito.");
        }

        while ($statement->fetch()) {
            return true;
        }

        return false;
    }

    public function checkNickname(string $nickname): bool {
        $statement = DatabaseConnection::getConnection()->prepare(
            "SELECT * FROM PC_USER WHERE use_nickname = ?"
        );
        
        if (!$statement->execute([$nickname])) {
            throw new \Exception("Echec de la requête pour récupérer les recettes de l'edito.");
        }

        while ($statement->fetch()) {
            return true;
        }

        return false;
    }

    public function insertUser(User $user): bool {
        $statement = DatabaseConnection::getConnection()->prepare(
            "INSERT INTO PC_USER (use_nickname, use_firstname, use_lastname, use_email, use_password)
            VALUES (?, ?, ?, ?, ?)"
        );

        return $statement->execute([
            $user->use_nickname,
            $user->use_firstname,
            $user->use_lastname,
            $user->use_email,
            $user->use_password,
        ]);
        
    }

    public function getUser(int $id) {
        $statement = DatabaseConnection::getConnection()->prepare(
            "SELECT USE_ID, USE_NICKNAME, USE_EMAIL, USE_FIRSTNAME, USE_LASTNAME, USE_PASSWORD, UTY_ID, UST_ID
            FROM PC_USER WHERE USE_ID = ?"
        );
        $statement->execute([$id]);

        if (!$row = $statement->fetch()) {
            throw new \Exception("La requête pour récupérer l'utilisateur à échoué.");
        }

        $user = new User();
        $user->use_id = intval($row["USE_ID"]);
        $user->use_nickname = $row["USE_NICKNAME"];
        $user->use_firstname = $row["USE_FIRSTNAME"];
        $user->use_lastname = $row["USE_LASTNAME"];
        $user->use_email = $row["USE_EMAIL"];
        $user->use_password = $row["USE_PASSWORD"];
        $user->uty_id = intval($row["UTY_ID"]);
        $user->ust_id = intval($row["UST_ID"]);

        return $user;
    }

    public function updateAccount(User $user){
        $statement = DatabaseConnection::getConnection()->prepare(
            "UPDATE PC_USER
            SET USE_NICKNAME = ?,
                USE_EMAIL = ?,
                USE_FIRSTNAME = ?,
                USE_LASTNAME = ?
            WHERE USE_ID = ?"
        );
        
        return $statement->execute([
            $user->use_nickname,
            $user->use_email,
            $user->use_firstname,
            $user->use_lastname,
            $user->use_id
        ]);
    }

    public function updatePassword(User $user){
        $statement = DatabaseConnection::getConnection()->prepare(
            "UPDATE PC_USER
            SET USE_PASSWORD = ?
            WHERE USE_ID = ?"
        );
            
        return $statement->execute([
            $user->use_password,
            $user->use_id
        ]);
    }
    
    public function updateUserStatus(int $use_id, int $ust_id){
        $statement = DatabaseConnection::getConnection()->prepare(
            "SELECT count(*) AS USER_COUNT
            FROM PC_USER
            WHERE USE_ID = ?"
        );
        $statement->execute([$use_id]);
        $row = $statement->fetch();

        if(intval($row["USER_COUNT"]) == 1){
            $statement = DatabaseConnection::getConnection()->prepare(
                "UPDATE PC_USER
                SET UST_ID = ? WHERE
                USE_ID = ?"
            );
            return !$statement->execute([$ust_id, $use_id]);
        } else {
            throw new \Exception("L'utilisateur n'existe pas.");
        }
    }
}
