<?php

function setupDatabase() // setup the database
{
    global $dbh;
    global $serverType;

    $delete = file_get_contents('includes/SQL/clearDatabase.sql');
    $data = $dbh->exec($delete);
    if ($serverType != "mysql") {
        $create = file_get_contents('includes/SQL/setupSQLsrv.sql');
    } else {
        $create = file_get_contents('includes/SQL/setupMySQL.sql');
    }
    $data = $dbh->exec($create);
    // distinguish between sqlsrv and MySQL
    $sql = file_get_contents('includes/SQL/constraints.sql');
    $data = $dbh->exec($sql);
    $toast = 'database reset completed';
}

function setupStatistics(){
    global $dbh;
    $statistics = file_get_contents('includes/SQL/admin.sql');
    $data =$dbh->exec($statistics);
    $toast = 'statistieken reset completed';
}

function getIPLocation(){

}