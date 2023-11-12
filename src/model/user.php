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
        $user->uty_id = intval($row["uty_ID"]);
        $user->ust_id = intval($row["ust_ID"]);

        return $user;
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
      
    /**
     * TODO Check
     */
    public function deleteUser($id){
        $sqlCheck = "SELECT * FROM User";
        $i=0;
        foreach  (DatabaseConnection::getConnection()->query($sqlCheck) as $line){
            $accounts[$i++] = $line;
        }

        $j = 0;
        foreach ($accounts as $account){
            if($id == $account['idUser']){
                $j = 1;
            }
        }

        if($j = 1){
            $sqlRemoveUser = "DELETE FROM user WHERE idUser = '$id'";
            DatabaseConnection::getConnection()->exec($sqlRemoveUser);
        }
        else{
            echo "There is no account with this id!";
        }
    }
    
    /**
     * TODO Check
     */
    public function updatePassword($newPassword, $id){
        $passwordUser = hash('sha256', $newPassword);
        $sqlUpdateUser = "UPDATE User SET passwordUser = '$passwordUser' WHERE idUser = $id";
        DatabaseConnection::getConnection()->exec($sqlUpdateUser);
    }
    
    /**
     * TODO Check
     */
    public function suspendUser($id){
        $sqlUpdateUser = "UPDATE User SET UST_CODE = '2' WHERE idUser = $id";
        DatabaseConnection::getConnection()->exec($sqlUpdateUser);
    }
}
