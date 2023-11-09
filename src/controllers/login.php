<?php

namespace Application\Controllers\Login;

require_once("./src/model/user.php");
require_once('./src/lib/status.php');

use Application\Model\User\UserModel;
use Application\Lib\Status\Status;

class Login {
    public function execute() {
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

        $model = new UserModel();
        $id = $model->login($email, hash("sha256", $password));
    
        $_SESSION["id"] = $id;
        $_SESSION["type"] = Status::getType($id);
    }
}

?>