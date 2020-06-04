<?php
session_start();
include_once('../classes/models/database.php');
require_once('database.php');
# check if database is setup
$data = $dbh->query("SELECT COUNT(*) AS aantal FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE='BASE TABLE'");
$result = $data->fetchAll(PDO::FETCH_COLUMN);
if($result[0] > 0){
    # check if there is still an admin
    $data = $dbh->query("SELECT COUNT(*) AS aantal FROM Gebruiker WHERE Action=1");
    $result = $data->fetchAll(PDO::FETCH_COLUMN);
    if($result[0] == 0) {
        $creation = file_get_contents('includes/SQL/defaultData.sql');
        $data = $dbh->exec($creation);
    }
} else {
    setupDatabase();
}

