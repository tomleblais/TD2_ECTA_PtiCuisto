<?php

namespace Application\Controllers\Edito;

require_once('./src/model/edito.php');
require_once('./src/model/recipe.php');

use Application\Model\Edito\Edito_m;
use Application\Model\Edito\Edito;
use Application\Model\Recipe\RecipeModel;

class Edito_c {

    public function showEdito(bool $update) {
        $content = (new Edito_m())->getContent();
        $recipes = (new RecipeModel())->getLatestRecipes();
        require('./templates/edito.php');
    }

    public function updateEdito(string $error = "") {
        $content = (new Edito_m())->getContent();
        require('./templates/admin/updateEdito.php');
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

        (new Edito_m())->updateEdito($edito);
    }
}