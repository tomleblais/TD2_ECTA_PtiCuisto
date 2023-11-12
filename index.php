<?php
session_start();

// Require -----------------------------------------------------------------
require_once('./src/model/user.php');
require_once('./src/controllers/permission.php');

require_once('./src/controllers/recipe.php');
require_once('./src/controllers/user.php');
require_once('./src/controllers/edito.php');
require_once('./src/controllers/comment.php');

// Use application ----------------------------------------------------------
use Application\Model\User\UserManager;
use Application\Controllers\Permission\Permission;

use Application\Controllers\Recipe\Recipe_c;
use Application\Controllers\User\User_c;
use Application\Controllers\Edito\Edito_c;
use Application\Controllers\Comment\Comment_c;

// Execute --------------------------------------------------------------------
$id = isset($_SESSION['id']) ? intval($_SESSION['id']) : null;
$type = isset($_SESSION['type']) ? $_SESSION['type'] : UserManager::USER;
$permission = new Permission($id, $type);
UserManager::setHeader($type);

try {
    if (isset($_GET['action']) && $_GET['action'] !== '') {
        // NONE -----------------------------------------------------------------------
        if ($type == UserManager::NONE) {
            throw new RangeException("Type d'utilisateur inconu, vous ne pouvez pas être John Doe !");
        }
        // USER -----------------------------------------------------------------------
        if ($_GET['action'] === 'allRecipes' && $permission->isAllowed('allRecipes')) {
            (new Recipe_c())->allRecipes();
        } elseif ($_GET['action'] === 'filteredRecipes' && $permission->isAllowed('filteredRecipes')) {
            // TODO filteredRecipes
        } elseif ($_GET['action'] === 'showRecipe' && $permission->isAllowed('showRecipe')) {
            if (isset($_GET['id'])) {
                $id = intval($_GET['id']);
                (new Recipe_c())->showRecipe($id, $permission->isAllowed('updateRecipe', $id));
            } else {
                throw new Exception('Aucun identifiant pour afficher une page');
            }
        } elseif ($_GET['action'] === 'writeCommentPost' && $permission->isAllowed('writeComment')) {
            if (isset($_GET['id'])) {
                $id = intval($_GET['id']);
                $erreur = (new Comment_c())->writeCommentPost($id, $permission->isAllowed('writeComment', $id));

                header("Location: ./index.php?action=showRecipe&id=$id");
            } else {
                throw new Exception('Aucun identifiant pour afficher une page');
            }
        } elseif ($_GET['action'] === 'login' && $permission->isAllowed('login')) {
            (new User_c())->login();
        } elseif ($_GET['action'] === 'loginPost' && $permission->isAllowed('loginPost')) {
            $user_c = new User_c();
            $error = $user_c->loginPost();

            if (!empty($error)) {
                $user_c->login($error);
            } else {
                header("Location: ./index.php");
            }
        } elseif ($_GET['action'] === 'filteredRecipesCategory' && $permission->isAllowed('filteredRecipesCategory')) {
            if (isset($_GET['post']) && $_GET['post']) {
                (new Recipe_c())->filteredRecipesCategory(true);
            } else {
                (new Recipe_c())->filteredRecipesCategory();
            }
        } elseif ($_GET['action'] === 'filteredRecipesTitle' && $permission->isAllowed('filteredRecipesTitle')) {
            if (isset($_GET['post']) && $_GET['post']) {
                (new Recipe_c())->filteredRecipesTitle(true);
            } else {
                (new Recipe_c())->filteredRecipesTitle();
            }
        } elseif ($_GET['action'] === 'filteredRecipesIngredient' && $permission->isAllowed('filteredRecipesIngredient')) {
            if (isset($_GET['post']) && $_GET['post']) {
                (new Recipe_c())->filteredRecipesIngredient(true);
            } else {
                (new Recipe_c())->filteredRecipesIngredient();
            }
        } elseif ($_GET['action'] === 'signin' && $permission->isAllowed('signin')) {
            (new User_c())->signin();
        } elseif ($_GET['action'] === 'signinPost' && $permission->isAllowed('signinPost')) {
            $user_c = new User_c();
            $error = $user_c->signinPost();

            if (!empty($error)) {
                $user_c->signin($error);
            } else {
                $user_c->login("Votre compte à était créé avec succée.");
            }
        } elseif ($_GET['action'] === 'showUser' && $permission->isAllowed('showUser')) {
            if (isset($_GET['id'])) {
                $id = intval($_GET['id']);
                (new User_c())->showUser($id);
            } else {
                throw new Exception('Aucun identifiant pour afficher une page');
            }
        } elseif ($_GET['action'] === 'updateUser' && $permission->isAllowed('updateUser')) {
            if (isset($_GET['id'])) {
                $id = intval($_GET['id']);
                (new User_c())->updateUser($id);
            } else {
                throw new Exception('Aucun identifiant pour afficher une page');
            }
        } elseif ($_GET['action'] === 'updateAccountPost' && $permission->isAllowed('updateUser')) {
            if (isset($_GET['id'])) {
                $id = intval($_GET['id']);
                (new User_c())->updateAccountPost($id);
            } else {
                throw new Exception('Aucun identifiant pour afficher une page');
            }
        } elseif ($_GET['action'] === 'updatePasswordPost' && $permission->isAllowed('updateUser')) {
            if (isset($_GET['id'])) {
                $id = intval($_GET['id']);
                (new User_c())->updatePasswordPost($id);
            } else {
                throw new Exception('Aucun identifiant pour afficher une page');
            }
        }
        // EDITER ---------------------------------------------------------------------
        elseif ($_GET['action'] === 'addRecipe' && $permission->isAllowed('allRecipe')) {
            (new Recipe_c())->addRecipe();
        } elseif ($_GET['action'] === 'myRecipes' && $permission->isAllowed('myRecipes')) {
            if (isset($_SESSION["id"])) {
                (new Recipe_c())->myRecipes($_SESSION["id"]);
            } else {
                throw new Exception("L'ID n'est pas déffinie");
            }
        } elseif ($_GET['action'] === 'updateRecipe' && $permission->isAllowed('updateRecipe')) {
            if (isset($_SESSION["id"])) {
                (new Recipe_c())->updateRecipe(intval($_GET['id']));
            } else {
                throw new Exception("L'ID n'est pas déffinie");
            }
        } elseif ($_GET['action'] === 'updateRecipePost') {
            if (isset($_GET['id'])) {
                $id = intval($_GET['id']);
                if ($permission->isAllowed('updateRecipePost', $id)) {
                    $recipe_c = new Recipe_c();
                    $error = $recipe_c->updateRecipePost($id);

                    if (!empty($error)) {
                        $recipe_c->updateRecipe($id, $error);
                    } else {
                        header("Location: ./index.php?action=showRecipe&id=$id");
                    }
                } else {
                    require('./templates/errors/error404.php');
                }
            } else {
                throw new Exception('Aucun identifiant pour afficher une page');
            }
        } elseif ($_GET['action'] === 'deleteRecipe') {
            if (isset($_GET['id'])) {
                $id = intval($_GET['id']);
                if ($permission->isAllowed('deleteRecipe', $id)) {
                    (new Recipe_c())->deleteRecipe($id);
                } else {
                    require('./templates/errors/error404.php');
                }
            } else {
                throw new Exception('Aucun identifiant pour supprimer la recette');
            }
        } elseif ($_GET['action'] === 'logout' && $permission->isAllowed('logout')) {
            (new User_c())->logout();
        }
        // ADMIN ----------------------------------------------------------------------
        elseif ($_GET['action'] === 'checkRecipes' && $permission->isAllowed('checkRecipes')) {
            (new Recipe_c())->checkRecipes();
        } elseif ($_GET['action'] === 'showRecipeUncheck' && $permission->isAllowed('showRecipeUncheck')) {
            if (isset($_GET['id'])) {
                (new Recipe_c())->showRecipeUncheck(intval($_GET['id']));
            } else {
                throw new Exception('Aucun identifiant pour afficher une page non validé');
            }
        } elseif ($_GET['action'] === 'checkRecipe' && $permission->isAllowed('checkRecipe')) {
            if (isset($_GET['id'])) {
                (new Recipe_c())->checkRecipe(intval($_GET['id']));
            } else {
                throw new Exception('Aucun identifiant pour validé la page !');
            }
        } elseif ($_GET['action'] === "updateEdito" && $permission->isAllowed('updateEdito')) {
            (new Edito_c())->updateEdito();
        } elseif ($_GET['action'] === 'updateEditoPost' && $permission->isAllowed('updateEditoPost')) {
            $edito_c = new Edito_c();
            $error = $edito_c->updateEditoPost();

            if (!empty($error)) {
                $edito_c->updateEdito($error);
            } else {
                header("Location: ./index.php");
            }
        } elseif ($_GET['action'] === 'showUsers' && $permission->isAllowed('showUsers')) {
            (new User_c())->showUsers();
        } elseif ($_GET['action'] === 'updateUserStatusPost' && $permission->isAllowed('updateUserStatus')) {
            if (isset($_GET['use_id'])) {
                $use_id = intval($_GET['use_id']);
                (new User_c())->updateUserStatusPost($use_id);
            } else {
                throw new Exception('Aucun identifiant pour afficher une page');
            }
        } else {
            require('./templates/errors/error404.php');
        }
    } else {
        (new Edito_c())->showEdito($type == UserManager::ADMIN);
    }
} catch (Exception $exception) {
    $errorMessage = $exception->getMessage();

    require('./templates/errors/error.php');
}