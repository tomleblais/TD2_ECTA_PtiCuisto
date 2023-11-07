<?php

namespace Application\Model\Connexion;

require_once('src/lib/database.php');

use Application\Lib\Database\DatabaseConnection;
use Exception;

class ConnexionModel {
    
    public function login($email, $password): int {
        
        $statement = DatabaseConnection::getConnection()->prepare(
            "SELECT COUNT(*) AS USER_COUNT FROM PC_USER WHERE USE_EMAIL = ? AND USE_PASSWORD = ?"
        );
        $statement->execute([$email, $password]);
        $result = $statement->fetch();
        
        if ($result["USER_COUNT"] != 1) {
            throw new Exception("Aucun utilisateur ne correspond");
            
        } else {
            $statement = DatabaseConnection::getConnection()->prepare(
                "SELECT USE_ID FROM PC_USER WHERE USE_EMAIL = ? AND USE_PASSWORD = ?"
            );
            $statement->execute([$email, $password]);
            $result = $statement->fetch();
    
            return $result["USE_ID"];
        }

    }

    public function insertUser($nicknameUser, $passwordUser, $emailUser, $firstnameUser, $lastnameUser) {
        $sqlCheck = "SELECT * FROM User";
        $i=0;
        foreach  (DatabaseConnection::getConnection()->query($sqlCheck) as $line){
            $accounts[$i++] = $line;
        }

        $j = 0;
        foreach ($accounts as $account){
            if($nicknameUser == $account['nicknameUser']){
                echo "This account already exists!";
                $j = 1;
            }
        }

        if($j = 0){
            $passwordUser = hash('sha256', $passwordUser);
            $sqlInsertUser = "INSERT INTO User (nicknameUser, passwordUser, emailUser, firstnameUser, lastnameUser, registrationDateUser) VALUES ('$nicknameUser', '$passwordUser', '$emailUser', '$firstnameUser', '$lastnameUser', NOW())";
            DatabaseConnection::getConnection()->exec($sqlInsertUser);
        }
    }
      
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
    
    public function updatePassword($newPassword, $id){
        $passwordUser = hash('sha256', $newPassword);
        $sqlUpdateUser = "UPDATE User SET passwordUser = '$passwordUser' WHERE idUser = $id";
        DatabaseConnection::getConnection()->exec($sqlUpdateUser);
    }
    
    public function suspendUser($id){
        $sqlUpdateUser = "UPDATE User SET UST_CODE = '2' WHERE idUser = $id";
        DatabaseConnection::getConnection()->exec($sqlUpdateUser);
    }
}

?>