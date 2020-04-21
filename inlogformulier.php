<?php

session_start();

$title = "inlogformulier";

require_once('includes/database.php');

require_once('includes/functions.php');

require_once('includes/header.php');

?>

<main>
    <form method="POST" action="inlogvalidatie.php"> 
        <label for="gebruikersnaam">Gebruikersnaam</label>
        <input type="text" name="username" id="gebruikersnaam" required> <br>
        <label for="wachtwoord"> Wachtwoord</label>
        <input type="password" name="password"  id="wachtwoord" required><br>
        <input type="submit" name="submit" value="Submit">
    </form>
</main>

<?php
require_once('includes/footer.php');
?>

        
