<?php

namespace Application\Lib\Database;

class DatabaseConnection {
    public ?\PDO $database = null;

    public function getConnection(): \PDO {
        if ($this->database === null) {
            $this->database = new \PDO('lien;dbname=nom;charset=utf8', 'blog', 'password');
        }

        return $this->database;
    }
}
