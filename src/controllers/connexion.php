<?php

namespace Application\Controllers\Connexion;

require_once('src/lib/database.php');

use Application\Lib\Database\DatabaseConnection;

class Connexion {

    public function execute() {
        require('templates/connexion.php');
    }
}

?>