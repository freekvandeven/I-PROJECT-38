<?php

function setupDatabase() // setup the database
{
    global $dbh;
    global $serverType;

    $delete = file_get_contents('includes/SQL/clearDatabase.sql');
    $data = $dbh->exec($delete);
    if ($serverType != "mysql") { // distinguish between sqlsrv and MySQL
        $create = file_get_contents('includes/SQL/setupSQLsrv.sql');
    } else {
        $create = file_get_contents('includes/SQL/setupMySQL.sql');
    }
    $data = $dbh->exec($create);
    $constraints = file_get_contents('includes/SQL/constraints.sql');
    $data = $dbh->exec($constraints);

    $creation = file_get_contents('includes/SQL/defaultData.sql');
    $data = $dbh->exec($creation);
    cleanupUploadFolder();
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