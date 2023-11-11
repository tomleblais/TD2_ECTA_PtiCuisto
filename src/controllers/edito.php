<?php

namespace Application\Controllers\Edito;

class Edito_c {

    public function showEdito() {
        require('./templates/edito.php');
    }

    public function updateEdito() {
        require('./templates/admin/updateEdito.php');
    }

    public function updateEditoPost() {
        // TODO
    }
}