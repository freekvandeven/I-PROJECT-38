<?php

class Database{

    static function testMethod(){
        echo "Testing classes";
    }

    static function connectToDatabase()
    {
        global $host;
        global $dbname;
        global $username;
        global $password;
        global $options;
        global $serverType;
        try {
            $dbh = new PDO("$serverType:$host;$dbname", $username, $password, $options);
            return $dbh;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }
}