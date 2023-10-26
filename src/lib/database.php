<?php

namespace Application\Lib\Database;

class DatabaseConnection {
    public ?\PDO $database = null;

    public function getConnection(): \PDO {
        if ($this->database === null) {
            $host = getenv('DB_HOST');
            $dbname = getenv('DB_NAME');
            $user = getenv('DB_USER');
            $pass = getenv('DB_PASS');

            try {
                $this->database = new \PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
                $this->database->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            } catch (\PDOException $error) {
                die("Erreur de connexion à la base de données : " . $error->getMessage());
            }
        }

        return $this->database;
    }
}

// $this->database = new \PDO('lien;dbname=nom;charset=utf8', 'blog', 'password');
