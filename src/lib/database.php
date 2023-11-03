<?php

namespace Application\Lib\Database;

class DatabaseConnection {
    private static ?\PDO $database = null;

    public static function getConnection(): \PDO {
        if (self::$database === null) {
            self::loadEnv();

            $host = getenv('DB_HOST');
            $port = getenv('DB_PORT');
            $dbname = getenv('DB_NAME');
            $user = getenv('DB_USER');
            $pass = getenv('DB_PASS');

            try {
                self::$database = new \PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $user, $pass);
            } catch (\PDOException $error) {
                die("Erreur de connexion à la base de données : " . $error->getMessage());
            }
        }        

        return self::$database;
    }
    
    private static function loadEnv() {
        $envFile = './.env';

        if (file_exists($envFile)) {
            $env = parse_ini_file($envFile);

            if ($env !== false) {
                foreach ($env as $key => $value) {
                    putenv("$key=$value");
                }
            } else {
                die("Erreur lors de la lecture du fichier .env");
            }
        } else {
            die("Le fichier .env n'existe pas.");
        }        
    }
}
