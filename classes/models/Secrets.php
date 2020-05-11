<?php
class Secrets {

    static function getSecrets(){
        $GLOBALS['host'] = 'host=localhost';
        //databasename you created with xampp
        $GLOBALS['dbname'] = 'dbname=I-Project38';
        //username is username you created with xampp
        $GLOBALS['username'] = 'Iproject38';
        //username is password you created with xampp
        $GLOBALS['password'] = 'Iproject38';
        //serverType is server you're using
        $GLOBALS['serverType'] = 'mysql';
    }
}