<?php

# code for filling database with items


# step 1 add categories

$file = file_get_contents('SQL/CREATE Categorieen.sql');

#step 1.1 remove constraint

$dbh->exec("ALTER TABLE Rubriek NOCHECK CONSTRAINT FK_ParentRubriek");
$dbh->exec("DELETE FROM Rubriek");
#step 1.2 fix insert string
$refactorFile = str_replace("INSERT Categorieen (ID,Name,Parent)", "INSERT INTO Rubriek (Rubrieknummer, Rubrieknaam, Rubriek)", $file);
#step 1.3 split file in inserts
$delimited = explode("\n", $refactorFile);
$inserts = array_slice($delimited, 2);
#step 1.4 loop over inserts
foreach($inserts as $insert){
    $dbh->query($insert);
}
#step 1.5 reapply constraint
$dbh->exec("ALTER TABLE Rubriek CHECK CONSTRAINT FK_ParentRubriek");


