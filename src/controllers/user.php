<?php

namespace Application\Controllers\User;

require_once("./src/model/user.php");

use Application\Model\User\UserManager;

class User_c {
    public function showUser(int $use_id){
        $user = (new UserManager())->getUser($use_id);
        require('./templates/showUser.php');
    }

    public function login(string $error = "") {
        require('./templates/login.php');
    }

    public function disableUserPost() {
        
    }
    
    public function loginPost() {
        if (!isset($_POST['email']) && !isset($_POST['password'])) {
            return "email ou mot de passe indéfini";
        }

        $email = htmlspecialchars(strtolower($_POST['email']));
        if (strlen($email) > 256 || strlen($email) < 0) {
            return "L'email est trop long ou trop court";
        }

        $emailPattern = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/";
        if (!preg_match($emailPattern, $email)) {
            return "Adresse email invalide";
        }
        
        $password = htmlspecialchars($_POST['password']);
        if (strlen($password) > 256 || strlen($password) < 0) {
            return "Le mot de passe est trop long ou trop court";
        }

        $id = (new UserManager())->login($email, hash("sha256", $password));
        if ($id === -1) {
            return "Adresse mail ou mot de passe invalide";
        }

        $_SESSION["id"] = $id;
        $_SESSION["type"] = UserManager::getType($id);
    }

    public function updateUserPost(){
        $email = htmlspecialchars(strtolower($_POST['email']));
        if (strlen($email) > 256 || strlen($email) < 0) {
            return "L'email est trop long ou trop court";
        }

        $emailPattern = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/";
        if (!preg_match($emailPattern, $email)) {
            return "Adresse email invalide";
        }
    }

    public function updatePasswordPost(){
        $password = htmlspecialchars($_POST['newpassword']);
        $password2 = htmlspecialchars($_POST['newpassword2']);
        if (strlen($password) > 256 || strlen($password) < 0) {
            return "Le nouveau mot de passe est trop long ou trop court";
        }

        if($password != $password2){
            return "Les 2 mots de passes ne sont pas identiques";
        }

        $id = (new UserManager())->login($email, hash("sha256", $password));
        if ($id === -1) {
            return "Mot de passe invalide";
        }
    }

    public function logout() {
        session_destroy();
        header("Location: ./index.php");
    }
}