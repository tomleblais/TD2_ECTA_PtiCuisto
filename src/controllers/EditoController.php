<?php

namespace Application\Controllers\EditoController;

require_once('./src/models/EditoModel.php');
require_once('./src/models/RecipeModel.php');

use Application\Model\EditoModel\Edito;
use Application\Model\EditoModel\EditoManager;
use Application\Model\RecipeModel\RecipeManager;

class EditoController {

    public function showEdito(bool $update) {
        $content = (new EditoManager())->getContent();
        $recipes = (new RecipeManager())->getLatestRecipes();
        require('./src/views/user/editoView.php');
    }

    public function updateEdito(string $error = "") {
        $content = (new EditoManager())->getContent();
        require('./src/views/admin/updateEditoView.php');
    }

    public function updateEditoPost() {
        if (!isset($_POST['content'])) {
            return "Le contenue ne peux pas être vide.";
        } elseif (mb_strlen($_POST['content'], 'UTF-8') > 2048) {
            return "Le contenue ne peut pas faire plus de 2048 caractères.";
        }  if (mb_strlen($_POST['content'], 'UTF-8') < 5) {
            return "Le contenue ne peut pas faire moins de 5 caractères.";
        }

        $edito = new Edito();
        $edito->edi_content = $_POST["content"];
        $edito->use_id = intval($_SESSION["id"]);

        (new EditoManager())->updateEdito($edito);
    }
}