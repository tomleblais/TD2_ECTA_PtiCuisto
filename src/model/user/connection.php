<?php

namespace Application\Model\Connection;

require_once('src/lib/database.php');

use Application\Lib\Database\DatabaseConnection;

class ConnectionModel {
    
    public function execute() {
        require('templates/connection.php');
    }

    public function login($email, $password): int {
        
        $statement = DatabaseConnection::getConnection()->prepare(
            "SELECT COUNT(*) AS user_count FROM User WHERE use_email = '?' AND use_password = '?'"
        );
        $statement->execute([$email, $password]);
        $row = $statement->fetch();
        
        if ($row["user_count"] != 1) {
            throw "Aucun utilisateur ne correspond";
            
        } else {
            $statement = DatabaseConnection::getConnection()->prepare(
                "SELECT use_id FROM User WHERE use_email = '?' AND use_password = '?'"
            );
            $statement->execute([$email, $password]);
            $row = $statement->fetch();
    
            return $row["use_id"];
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