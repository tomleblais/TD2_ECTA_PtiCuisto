<?php

namespace Application\Controllers\UserController;

require_once("./src/models/UserModel.php");

use Application\Model\UserModel\User;
use Application\Model\UserModel\UserManager;

class UserController {
    public function signin(string $error = "") {
        require('./src/views/user/signinView.php');
    }

    public function userDetails(int $use_id){
        $user = (new UserManager())->getUser($use_id);

        require('./src/views/user/userDetailsView.php');
    }

    public function allUsers() {
        $users = (new UserManager())->getUsers();   

        require('./src/views/admin/allUsersView.php');
    }

    public function updateUser(int $use_id) {
        $user = (new UserManager())->getUser($use_id);

        require("./src/views/user/updateUserView.php");
    }

    public function updateUserStatusPost(int $use_id) {
        $ust_id = intval($_POST['status']);
        (new UserManager())->updateUserStatus($use_id, $ust_id);

        header("Location: ./index.php?action=allUsers");
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
        require('./src/views/user/loginView.php');
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

    public function updateAccountPost(int $use_id){

        $use_nickname = htmlspecialchars($_POST['nickname']);
        $use_firstname = htmlspecialchars($_POST['firstname']);
        $use_lastname = htmlspecialchars($_POST['lastname']);
        $email = htmlspecialchars(strtolower($_POST['email']));

        if (strlen($email) > 256 || strlen($email) < 0) {
            return "L'email est trop long ou trop court";
        } elseif (empty($use_nickname) || strlen($use_nickname) > 32) {
            return "Le nom d'utilisateur est trop long ou trop court";
        } elseif (empty($use_firstname) || strlen($use_firstname) > 32) {
            return "Le prénom est trop long ou trop court";
        } elseif (empty($use_lastname) || strlen($use_lastname) > 32) {
            return "Le nom est trop long ou trop court";
        }

        $emailPattern = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/";
        if (!preg_match($emailPattern, $email)) {
            return "Adresse email invalide";
        }

        $user = new User();
        $user->use_id = $use_id;
        $user->use_nickname = $use_nickname;
        $user->use_firstname = $use_firstname;
        $user->use_lastname = $use_lastname;
        $user->use_email = $email;

        (new UserManager())->updateAccount($user);

        header("Location: ./index.php?action=userDetails&id=$user->use_id");
    }

    public function updatePasswordPost(int $use_id){

        $old_password = htmlspecialchars($_POST['oldpassword']);
        
        $new_password = htmlspecialchars($_POST['newpassword']);
        $new_password2 = htmlspecialchars($_POST['newpassword2']);

        if (strlen($new_password) > 256 || strlen($new_password) < 0) {
            return "Le nouveau mot de passe est trop long ou trop court.";
        } elseif ($new_password != $new_password2){
            return "Les deux mots de passes ne correspondent pas.";
        }

        $user = new User();
        $user->use_id = $use_id;
        $user->use_password = hash("sha256", $new_password);

        (new UserManager())->updatePassword($user);

        header("Location: ./index.php?action=userDetails&id=$user->use_id");
    }

    public function logout() {
        session_destroy();
        header("Location: ./index.php");
    }
}