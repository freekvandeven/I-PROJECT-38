<?php

session_start();



$title = "Homepage";

require_once('includes/database.php');

require_once('includes/functions.php');



require_once('includes/header.php');



echo "Testing homepage";



require_once('includes/footer.php');

?>

<!Doctype HTML>
<html lang="nl">
    <head>
        <title>Amos Middelkoop</title>
        <meta charset="UTF-8">
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <link rel="stylesheet">
    </head>
    <body>
        <main>
            <form method="POST" action="registratiehandling.php"> 
                <label for="gebruikersnaam">Gebruikersnaam</label>
                <input type="text" name="username" id="gebruikersnaam" required> <br>
                <label for="wachtwoord"> Wachtwoord</label>
                <input type="password" name="password"  id="wachtwoord" required><br>
                <label for= "email-adres">Email</label>
                <input type="email" name="email" id="email-adres" required> <br>
                <label for= "voornaam">Voornaam</label>
                <input type="text" name="first-name" id="voornaam" required> <br>
                <label for= "achternaam">Achternaam</label>
                <input type="text" name="surname" id="achternaam" required> <br>
                <label for= "adres">Adres</label>
                <input type="text" name="adress" id="adres" required> <br>
                <label for= "postcode">Postcode</label>
                <input type="text" name="postcode" id="postcode" required> <br>
                <label for= "plaats">Plaats</label>
                <input type="text" name="place" id="plaats" required> <br>
                <label for= "land">Land</label>
                <input type="text" name="country" id="land" required> <br>
                <label for= "telefoonnummer">Telefoonnummer</label>
                <input type="text" name="phone-number" id="telefoonnummer" required> <br>
                <label for= "telefoonnummer2">Telefoonnummer 2</label>
                <input type="text" name="phone-number2" id="telefoonnummer2"> <br>
                <label for= "geboortedatum">Geboortedatum</label>
                <input type="date" name="birth-date" id="geboortedatum"> <br>
                <label for= "geheime-vraag">Geheime vraag</label>
                <input type="text" name="secret-question" id="geheime-vraag" required> <br>
                <label for= "geheim-antwoord">Geheim antwoord</label>
                <input type="text" name="secret-answer" id="geheim-antwoord" required> <br>
                <input type="submit" name="submit" value="Submit">
            </form>
        </main>
