<?php

namespace Application\Controllers\Connection;

require_once('src/lib/database.php');

use Application\Lib\Database\DatabaseConnection;

class Connection {

    public function execute() {
        require('templates/connection.php');
    }
}

?>