<?php

namespace Application\Controllers\Admin\UpdateEdito;

require_once('src/model/admin/updateEdito.php');

use Application\Model\Admin\UpdateEdito\UpdateEditoModel;

class UpdateEdito {
    public function execute() {
        $updateEditoModel = new UpdateEditoModel();

        require('templates/admin/updateEdito.php');
    }
}
