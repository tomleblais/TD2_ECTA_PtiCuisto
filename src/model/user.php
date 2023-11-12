<?php

namespace Application\Model\User;

require_once('./src/lib/database.php');

use Application\Lib\Database\DatabaseConnection;

class User {
    public int $use_id;
    public string  $use_nickname;
    public int $ust_id;

}

class UserManager
{
    public const NONE = 0;
    public const USER = 1;
    public const EDITER = 2;
    public const ADMIN = 3;

    public static function getType(int $id): int
    {
        $statement = DatabaseConnection::getConnection()->prepare(
            "SELECT uty_id FROM PC_USER WHERE use_id = ?"
        );
        $statement->execute([$id]);

        return self::numberToConst($statement->fetch()["uty_id"]);
    }

    public function getUsers(): array{
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

    public function getUser(int $use_id) : User
    {
        $statement = DatabaseConnection::getConnection()->prepare(
            "SELECT USE_ID, USE_NICKNAME, UST_ID FROM PC_USERS
            JOIN PC_USER_STATUS USING (UST_ID)
            WHERE use_id = ?"
        );
        $statement->execute([$use_id]);

        if (!($row = $statement->fetch())) {
            throw new \Exception("L'utilisateur n'a pas pu être trouvée !");
        }

            $user = new User();
            $user->use_id = intval($row["use_id"]);
            $user->use_nickname = $row["use_nickname"];
            $user->ust_id = $row["ust_id"];
        return $user;

    }

    private static function numberToConst(int $number): int
    {
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

    public static function setHeader(int $type)
    {
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

    public function login($email, $password): int
    {
        $statement = DatabaseConnection::getConnection()->prepare(
            "SELECT COUNT(*) AS USER_COUNT FROM PC_USER WHERE USE_EMAIL = ? AND USE_PASSWORD = ?"
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

    public function insertUser($nicknameUser, $passwordUser, $emailUser, $firstnameUser, $lastnameUser)
    {
        $sqlCheck = "SELECT * FROM User";
        $i = 0;
        foreach (DatabaseConnection::getConnection()->query($sqlCheck) as $line) {
            $accounts[$i++] = $line;
        }

        $j = 0;
        foreach ($accounts as $account) {
            if ($nicknameUser == $account['nicknameUser']) {
                echo "This account already exists!";
                $j = 1;
            }
        }

        if ($j = 0) {
            $passwordUser = hash('sha256', $passwordUser);
            $sqlInsertUser = "INSERT INTO User (nicknameUser, passwordUser, emailUser, firstnameUser, lastnameUser, registrationDateUser) VALUES ('$nicknameUser', '$passwordUser', '$emailUser', '$firstnameUser', '$lastnameUser', NOW())";
            DatabaseConnection::getConnection()->exec($sqlInsertUser);
        }
    }

    public function deleteUser($id)
    {
        $sqlCheck = "SELECT * FROM User";
        $i = 0;
        foreach (DatabaseConnection::getConnection()->query($sqlCheck) as $line) {
            $accounts[$i++] = $line;
        }

        $j = 0;
        foreach ($accounts as $account) {
            if ($id == $account['idUser']) {
                $j = 1;
            }
        }

        if ($j = 1) {
            $sqlRemoveUser = "DELETE FROM user WHERE idUser = '$id'";
            DatabaseConnection::getConnection()->exec($sqlRemoveUser);
        } else {
            echo "There is no account with this id!";
        }
    }

    public function updatePassword($newPassword, $id)
    {
        $passwordUser = hash('sha256', $newPassword);
        $sqlUpdateUser = "UPDATE User SET passwordUser = '$passwordUser' WHERE idUser = $id";
        DatabaseConnection::getConnection()->exec($sqlUpdateUser);
    }

    public function suspendUser($id)
    {
        $sqlUpdateUser = "UPDATE User SET UST_CODE = '2' WHERE idUser = $id";
        DatabaseConnection::getConnection()->exec($sqlUpdateUser);
    }
}
