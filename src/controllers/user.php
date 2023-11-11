<?php

namespace Application\Controllers\User;

require_once("./src/model/user.php");

use Application\Model\User\UserManager;

class User_c {

    public function connexion() {
        require('./templates/connexion.php');
    }
    
    public function login() {
        if(!isset($_POST['email']) && !isset($_POST['password'])){
            return "email ou mot de passe indéfini";
        }

        $email = htmlspecialchars(strtolower($_POST['email']));
        $password = htmlspecialchars($_POST['password']);
        
        if(strlen($password) > 256 || strlen($password) < 0){
            return "Le mot de passe est trop long ou trop court";
        }

        if(strlen($email) > 256 || strlen($email) < 0){
            return "L'email est trop long ou trop court";
        }

        $emailPattern = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/";
        if (!preg_match($emailPattern, $email)) {
            return "Adresse email invalide";
        }

        $model = new UserManager();
        $id = $model->login($email, hash("sha256", $password));
    
        $_SESSION["id"] = $id;
        $_SESSION["type"] = UserManager::getType($id);

        header("Location: ./index.php");
    }
}