<?php

class PdoFactory {
    public function create() {
        $host = "localhost";
        $user = "iugo";
        $password = "iugo";
        $database = "IugoGame";
        
        $opt = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ];

        $dataSourceName = "mysql:host=$host;dbname=$database;charset=utf8";
        return new PDO($dataSourceName, $user, $password, $opt);
    }
}
