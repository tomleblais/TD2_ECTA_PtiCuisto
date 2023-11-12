<?php

namespace Application\Model\EditoModel;

require_once('./src/lib/database.php');

use Application\Lib\Database\DatabaseConnection;

class Edito {
    public string $edi_content;
    public int $use_id;
}

class EditoManager {
    public function getContent() : string {
        $statement = DatabaseConnection::getConnection()->prepare(
            "SELECT edi_content FROM PC_EDITO WHERE edi_id = (
                SELECT max(edi_id) FROM PC_EDITO
            )"
        );
        $statement->execute();

        if (($row = $statement->fetch()) == null) {
            return "Il n'y a rien pour le moment.";
        } else {
            return $row["edi_content"];
        }
    }

    public function updateEdito(Edito $edito) {
        $statement = DatabaseConnection::getConnection()->prepare(
            "INSERT INTO PC_EDITO (use_id, edi_content, edi_date_modif) VALUES (
                ?,
                ?,
                NOW()
            )"
        );

        if (!$statement->execute([$edito->use_id, $edito->edi_content])) {
            throw new \Exception("L'edito n'a pas été mis à jour.");
        }
    }
}