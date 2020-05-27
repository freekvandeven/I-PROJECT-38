<?php

function setupDatabase() // setup the database
{
    global $dbh;
    $sql = file_get_contents('includes/SQL/setupSqlsrv.sql');
    $data = $dbh->exec($sql);
}

?>