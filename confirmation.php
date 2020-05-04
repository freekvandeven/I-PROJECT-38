<?php
require_once('includes/database.php');
require_once('includes/functions.php');

//Naam onthouden
$name = $_POST['first-name'];

$stmt = $dbh->prepare("ALTER TABLE Gebruiker ADD Bevestiging bit NOT NULL ");
$stmt->execute();

$stmt_df = $dbh->prepare("ALTER table Gebruiker ADD CONSTRAINT default0 DEFAULT 0 FOR Bevestiging");
$stmt_df->execute();

// Opmaak email
$to = $_POST['email'];
$subject = "Bevestigingsmail";
$msg = "Beste $name!,";
$mgs .= "Hartelijk bedankt voor het sturen van jouw registratie! 
Klik hieronder voor de bevestiging van jouw account!";

// Bevestiging verzenden
$formsent = mail($to,$subject,$msg);


