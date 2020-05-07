<?php
$input = $_POST['newRubriek'];
$data = $dbh->prepare('INSERT INTO Rubriek (Rubrieknaam, Rubriek, Volgnr) VALUES (:Rubrieknaam , 5, 5)');
$data->execute([":Rubrieknaam"=>$_POST['newRubriek']]);
