<?php

function setupDatabase() // setup the database
{
    global $dbh;

    // distinguish between sqlsrv and MySQL
    $sql = file_get_contents('includes/SQL/setupSqlsrv.sql');
    $data = $dbh->exec($sql);
}

function getIPLocation(){

}