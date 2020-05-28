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
    setupProcedures();
    $toast = 'database reset completed';
}

function setupProcedures(){
    global $dbh;
    $clear = file_get_contents('includes/SQL/clearProcedures.sql');
    $data = $dbh->exec($clear);
    $procedures = file_get_contents('includes/SQL/storedProcedures.sql');
    $procedures = explode("END;", $procedures);
    foreach ($procedures as $procedure){
        $data = $dbh->exec($procedure."END;");
    }
}

function setupStatistics(){
    global $dbh;
    $statistics = file_get_contents('includes/SQL/admin.sql');
    $data =$dbh->exec($statistics);
    $toast = 'statistieken reset completed';
}

function getIPLocation(){

}