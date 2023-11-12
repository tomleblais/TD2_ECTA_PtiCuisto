<?php

namespace Application\Controllers\User;

require_once("./src/model/user.php");

use Application\Model\User\User;
use Application\Model\User\UserManager;

class User_c {
    public function signin(string $error = "") {
        require('./templates/signin.php');
    }
    public function showUsers() {
        $users = (new UserManager())->getUsers();   

        require('./templates/admin/showUsers.php');
    }

    public function updateUserStatusPost(int $use_id) {
        $ust_id = intval($_POST['status']);
        (new UserManager())->updateUserStatus($use_id, $ust_id);

        header("Location: ./index.php?action=showUsers");
    }
    public function signinPost() {
        if (!isset($_POST['nickname'])) {
            return "Nom d'utilisateur indéfini.";
        } elseif (!isset($_POST['firstname'])) {
            return "Prénom indéfini.";
        } elseif (!isset($_POST['lastname'])) {
            return "Nom indéfini.";
        } elseif (!isset($_POST['email'])) {
            return "Adresse mail indéfini.";
        } elseif (!isset($_POST['password'])) {
            return "Mot de passe indéfini.";
        } elseif (!isset($_POST['password2'])) {
            return "Confirmation du mot de passe indéfini.";
        }

        $user = new User();
        $user->use_nickname = $_POST["nickname"];
        $user->use_firstname = $_POST["firstname"];
        $user->use_lastname = $_POST["lastname"];
        $user->use_email = htmlspecialchars(strtolower($_POST['email']));
        $user->use_password = hash("sha256", htmlspecialchars($_POST['password']));

        if (mb_strlen($user->use_nickname, 'UTF-8') > 32) {
            return "Le nom d'utilisateur ne peut pas faire plus de 32 caractères.";
        } elseif (mb_strlen($user->use_nickname, 'UTF-8') < 3) {
            return "Le nom d'utilisateur ne peut pas faire moins de 3 caractères";
        } elseif (mb_strlen($user->use_firstname, 'UTF-8') > 32) {
            return "Votre prénom ne peut pas faire plus de 32 caractères.";
        } elseif (mb_strlen($user->use_firstname, 'UTF-8') < 3) {
            return "Votre prénom ne peut pas faire moins de 3 caractères";
        } elseif (mb_strlen($user->use_lastname, 'UTF-8') > 32) {
            return "Votre nom ne peut pas faire plus de 32 caractères.";
        } elseif (mb_strlen($user->use_lastname, 'UTF-8') < 3) {
            return "Votre nom ne peut pas faire moins de 3 caractères";
        } elseif (mb_strlen($user->use_email, 'UTF-8') > 128) {
            return "Votre email ne peut pas faire plus de 128 caractères.";
        } elseif (mb_strlen($user->use_email, 'UTF-8') < 3) {
            return "Votre email ne peut pas faire moins de 3 caractères";
        } elseif (strlen($user->use_password) > 256 || strlen($user->use_password) < 2) {
            return "Le mot de passe est trop long ou trop court, entre 8 et 256 caractères";
        } elseif ($_POST["password"] !== $_POST["password2"]) {
            return "Les deux mots de passe ne correspondent pas.";
        }

        if (!preg_match(
            "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", 
            $user->use_email)
        ) {
            return "Adresse email invalide";
        }

        $user_m = new UserManager();
        if ($user_m->checkEmail($user->use_email)) {
            return "Email déjà utilisé.";
        } elseif ($user_m->checkNickname($user->use_nickname)) {
            return "Nom d'utilisateur déjà utilisé.";
        }

        if (!$user_m->insertUser($user)) {
            return "Votre compte n'a pas était ajouté.";
        }
    }

    public function login(string $error = "") {
        require('./templates/login.php');
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

    public function showUser(int $use_id){
        $user = (new UserManager())->getUser($use_id);
        require('./templates/showUser.php');
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

    /*public function updatePasswordPost(){
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
    }*/

    public function logout() {
        session_destroy();
        header("Location: ./index.php");
    }
}