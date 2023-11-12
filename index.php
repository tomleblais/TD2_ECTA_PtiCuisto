<?php
session_start();

// Require -----------------------------------------------------------------
require_once('./src/models/UserModel.php');
require_once('./src/controllers/PermissionController.php');

require_once('./src/controllers/RecipeController.php');
require_once('./src/controllers/UserController.php');
require_once('./src/controllers/EditoController.php');
require_once('./src/controllers/CommentController.php');

// Use application ----------------------------------------------------------
use Application\Model\UserModel\UserManager;

use Application\Controllers\PermissionController\Permission;
use Application\Controllers\RecipeController\RecipeController;
use Application\Controllers\UserController\UserController;
use Application\Controllers\EditoController\EditoController;
use Application\Controllers\CommentController\CommentController;

// Execute --------------------------------------------------------------------
$id = isset($_SESSION['id']) ? intval($_SESSION['id']) : null;
$type = isset($_SESSION['type']) ? $_SESSION['type'] : UserManager::USER;
$permission = new Permission($id, $type);
UserManager::setHeader($type);

try {
    if (isset($_GET['action']) && $_GET['action'] !== '') {
        // NONE -----------------------------------------------------------------------
        if ($type == UserManager::NONE) {
            throw new RangeException("Type d'utilisateur inconnu, vous ne pouvez pas être John Doe !");
        }
        // USER -----------------------------------------------------------------------
        if ($_GET['action'] === 'allRecipes' && $permission->isAllowed('allRecipes')) {
            (new RecipeController())->allRecipes();
        } elseif ($_GET['action'] === 'filteredRecipes' && $permission->isAllowed('filteredRecipes')) {
            // TODO filteredRecipes
        } elseif ($_GET['action'] === 'recipeDetails' && $permission->isAllowed('recipeDetails')) {
            if (isset($_GET['id'])) {
                $id = intval($_GET['id']);
                (new RecipeController())->recipeDetails($id, $permission->isAllowed('recipeDetails', $id));
            } else {
                throw new Exception('Aucun identifiant pour afficher une page');
            }
        } elseif ($_GET['action'] === 'writeCommentPost' && $permission->isAllowed('writeComment')) {
            if (isset($_GET['id'])) {
                $id = intval($_GET['id']);
                $erreur = (new CommentController())->writeCommentPost($id, $permission->isAllowed('writeComment', $id));

                header("Location: ./index.php?action=recipeDetails&id=$id");
            } else {
                throw new Exception('Aucun identifiant pour afficher une page');
            }
        } elseif ($_GET['action'] === 'login' && $permission->isAllowed('login')) {
            (new UserController())->login();
        } elseif ($_GET['action'] === 'loginPost' && $permission->isAllowed('loginPost')) {
            $user_c = new UserController();
            $error = $user_c->loginPost();

            if (!empty($error)) {
                $user_c->login($error);
            } else {
                header("Location: ./index.php");
            }
        } elseif ($_GET['action'] === 'filteredRecipesCategory' && $permission->isAllowed('filteredRecipesCategory')) {
            if (isset($_GET['post']) && $_GET['post']) {
                (new RecipeController())->filteredRecipesCategory(true);
            } else {
                (new RecipeController())->filteredRecipesCategory();
            }
        } elseif ($_GET['action'] === 'filteredRecipesTitle' && $permission->isAllowed('filteredRecipesTitle')) {
            if (isset($_GET['post']) && $_GET['post']) {
                (new RecipeController())->filteredRecipesTitle(true);
            } else {
                (new RecipeController())->filteredRecipesTitle();
            }
        } elseif ($_GET['action'] === 'filteredRecipesIngredient' && $permission->isAllowed('filteredRecipesIngredient')) {
            if (isset($_GET['post']) && $_GET['post']) {
                (new RecipeController())->filteredRecipesIngredient(true);
            } else {
                (new RecipeController())->filteredRecipesIngredient();
            }
        } elseif ($_GET['action'] === 'signin' && $permission->isAllowed('signin')) {
            (new UserController())->signin();
        } elseif ($_GET['action'] === 'signinPost' && $permission->isAllowed('signinPost')) {
            $user_c = new UserController();
            $error = $user_c->signinPost();

            if (!empty($error)) {
                $user_c->signin($error);
            } else {
                $user_c->login("Votre compte a été créé avec succès.");
            }
        } elseif ($_GET['action'] === 'userDetails' && $permission->isAllowed('userDetails')) {
            if (isset($_GET['id'])) {
                $id = intval($_GET['id']);
                (new UserController())->userDetails($id);
            } else {
                throw new Exception('Aucun identifiant pour afficher une page');
            }
        } elseif ($_GET['action'] === 'updateUser' && $permission->isAllowed('updateUser')) {
            if (isset($_GET['id'])) {
                $id = intval($_GET['id']);
                (new UserController())->updateUser($id);
            } else {
                throw new Exception('Aucun identifiant pour afficher une page');
            }
        } elseif ($_GET['action'] === 'updateAccountPost' && $permission->isAllowed('updateUser')) {
            if (isset($_GET['id'])) {
                $id = intval($_GET['id']);
                (new UserController())->updateAccountPost($id);
            } else {
                throw new Exception('Aucun identifiant pour afficher une page');
            }
        } elseif ($_GET['action'] === 'updatePasswordPost' && $permission->isAllowed('updateUser')) {
            if (isset($_GET['id'])) {
                $id = intval($_GET['id']);
                (new UserController())->updatePasswordPost($id);
            } else {
                throw new Exception('Aucun identifiant pour afficher une page');
            }
        }
        // EDITER ---------------------------------------------------------------------
        elseif ($_GET['action'] === 'addRecipe' && $permission->isAllowed('allRecipe')) {
            (new RecipeController())->addRecipe();
        } elseif ($_GET['action'] === 'addRecipePost' &&  $permission->isAllowed('addRecipe')) {
            if (isset($_SESSION["id"])) {
                $id = intval($_SESSION["id"]);
            (new RecipeController())->addRecipePost($_SESSION["id"]);
            } else {
                throw new Exception("L'ID n'est pas définie");
            }
        } elseif ($_GET['action'] === 'myRecipes' && $permission->isAllowed('myRecipes')) {
            if (isset($_SESSION["id"])) {
                (new RecipeController())->myRecipes($_SESSION["id"]);
            } else {
                throw new Exception("L'ID n'est pas définie");
            }
        } elseif ($_GET['action'] === 'updateRecipe' && $permission->isAllowed('updateRecipe')) {
            if (isset($_SESSION["id"])) {
                (new RecipeController())->updateRecipe(intval($_GET['id']));
            } else {
                throw new Exception("L'ID n'est pas définie");
            }
        } elseif ($_GET['action'] === 'updateRecipePost') {
            if (isset($_GET['id'])) {
                $id = intval($_GET['id']);
                if ($permission->isAllowed('updateRecipePost', $id)) {
                    $recipe_c = new RecipeController();
                    $error = $recipe_c->updateRecipePost($id);

                    if (!empty($error)) {
                        $recipe_c->updateRecipe($id, $error);
                    } else {
                        header("Location: ./index.php?action=recipeDetails&id=$id");
                    }
                } else {
                    require('./src/views/errors/error404.php');
                }
            } else {
                throw new Exception('Aucun identifiant pour afficher une page');
            }
        } elseif ($_GET['action'] === 'deleteRecipe') {
            if (isset($_GET['id'])) {
                $id = intval($_GET['id']);
                if ($permission->isAllowed('deleteRecipe', $id)) {
                    (new RecipeController())->deleteRecipe($id);
                } else {
                    require('./src/views/errors/error404.php');
                }
            } else {
                throw new Exception('Aucun identifiant pour supprimer la recette');
            }
        } elseif ($_GET['action'] === 'logout' && $permission->isAllowed('logout')) {
            (new UserController())->logout();
        }  elseif ($_GET['action'] === 'userDetails' && $permission->isAllowed('userDetails')) {
            if (isset($_GET['id'])) {
                (new UserController())->userDetails(intval($_GET['id']));
            } elseif (isset($_SESSION['id'])) {
                (new UserController())->userDetails($id);
            } else {
                throw new Exception('Aucun identifiant pour afficher une page');
            }
        }
        // ADMIN ----------------------------------------------------------------------
        elseif ($_GET['action'] === 'checkRecipes' && $permission->isAllowed('checkRecipes')) {
            (new RecipeController())->checkRecipes();
        } elseif ($_GET['action'] === 'allUncheckedRecipes' && $permission->isAllowed('allUncheckedRecipes')) {
            if (isset($_GET['id'])) {
                (new RecipeController())->allUncheckedRecipes(intval($_GET['id']));
            } else {
                throw new Exception('Aucun identifiant pour afficher une page non validée');
            }
        } elseif ($_GET['action'] === 'checkRecipe' && $permission->isAllowed('checkRecipe')) {
            if (isset($_GET['id'])) {
                (new RecipeController())->checkRecipe(intval($_GET['id']));
            } else {
                throw new Exception('Aucun identifiant pour valider la page !');
            }
        } elseif ($_GET['action'] === "updateEdito" && $permission->isAllowed('updateEdito')) {
            (new EditoController())->updateEdito();
        } elseif ($_GET['action'] === 'updateEditoPost' && $permission->isAllowed('updateEditoPost')) {
            $edito_c = new EditoController();
            $error = $edito_c->updateEditoPost();

            if (!empty($error)) {
                $edito_c->updateEdito($error);
            } else {
                header("Location: ./index.php");
            }
        } elseif ($_GET['action'] === 'allUsers' && $permission->isAllowed('allUsers')) {
            (new UserController())->allUsers();
        } elseif ($_GET['action'] === 'updateUserStatusPost' && $permission->isAllowed('updateUserStatus')) {
            if (isset($_GET['use_id'])) {
                $use_id = intval($_GET['use_id']);
                (new UserController())->updateUserStatusPost($use_id);
            } else {
                throw new Exception('Aucun identifiant pour afficher une page');
            }
        } else {
            require('./src/views/errors/error404.php');
        }
    } else {
        (new EditoController())->showEdito($type == UserManager::ADMIN);
    }
} catch (Exception $exception) {
    $errorMessage = $exception->getMessage();

    require('./src/views/errors/error.php');
}