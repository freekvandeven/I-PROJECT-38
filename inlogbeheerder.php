<?php

session_start();

$title = "inlogbeheerder";

require_once('includes/database.php');

require_once('includes/functions.php');

require_once('includes/header.php');

if (isset($_POST['submit'])) {
    $username = $_POST['username'];

    $profile_data = getUser($username);

    if( profile_data['Gebruikersnaam'] == $username && profile_data['Action'] == 1){
        header('Location: admin.php');
    } 
  }

?>

<h2>Inlog voor beheerder</h2>

<main>
    <form method="POST" action="inlogbeheerder.php"> 
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