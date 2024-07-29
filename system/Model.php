<?php
namespace System;

class Model {
    protected static \PDO $database;
    public static function dbConnect() {
        if(empty(self::$database)) {
            LOGGER->log("Opening database");
            self::$database=new \PDO("sqlite:".DATA_DIR."/database.sqlite3");
        }
    }
    public static function dbQuery(string $query,array $args=[]):\PDOStatement {
        self::dbConnect();
        $statement=self::$database->prepare($query);
        $statement->execute($args);
        return $statement;
    }
}