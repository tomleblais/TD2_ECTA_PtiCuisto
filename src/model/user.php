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
            "SELECT USE_ID, USE_NICKNAME, UST_ID FROM PC_USERS
            JOIN PC_USER_STATUS USING (UST_ID)"
        );
        $statement->execute();

        $users = [];

        while (($row = $statement->fetch())) {
            $user = new User();
            $user->use_id = intval($row["use_id"]);
            $user->use_nickname = $row["use_nickname"];
            $user->ust_id = $row["ust_id"];

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
            "SELECT * FROM PC_USER WHERE use_id = ?"
        );
        $statement->execute([$id]);

        if (!$row = $statement->fetch()) {
            throw new \Exception("La requête pour récupérer l'utilisateur à échoué.");
        }

        $user = new User();
        $user->use_id = intval($row["use_id"]);
        $user->use_nickname = $row["use_nickname"];
        $user->use_firstname = $row["use_firstname"];
        $user->use_lastname = $row["use_lastname"];
        $user->use_email = $row["use_email"];
        $user->use_password = $row["use_password"];
        $user->uty_id = intval($row["uty_id"]);
        $user->ust_id = intval($row["ust_id"]);

        return $user;
    }

    public function updateUser(User $user){
        $statement = DatabaseConnection::getConnection()->prepare(
            "UPDATE PC_USER set use_nickname = ?, use_email = ?, use_firstname = ?, use_lastname = ? where use_id = ?"
        );
        
        return $statement->execute([
            $user->use_nickname,
            $user->use_firstname,
            $user->use_lastname,
            $user->use_email,
        ]);
    }

    public function updatePassword(User $user){
        $statement = DatabaseConnection::getConnection()->prepare(
            "UPDATE PC_USER set use_password = ? where use_id = ?"
        );
            
        return $statement->execute([
            $user->use_password,
        ]);
    }
    
    public function deleteUser(int $id){
        $statement = DatabaseConnection::getConnection()->prepare(
            "SELECT count(*) as nb FROM PC_USER WHERE use_id = ?"
        );
        $statement->execute([$id]);
        $row = $statement->fetch();
        if($row == 1){
            $statement = DatabaseConnection::getConnection()->prepare(
            "UPDATE PC_USER SET ust_id = 3 WHERE use_id = ?"  
            );
            return !$statement->execute([$id]);
        }
        else{
            throw new \Exception("L'utilisateur n'existe pas !");
        }
    }
    
    /**
     * TODO Check
     */
    public function suspendUser($id){
        $sqlUpdateUser = "UPDATE User SET UST_CODE = '2' WHERE idUser = $id";
        DatabaseConnection::getConnection()->exec($sqlUpdateUser);
    }
}
