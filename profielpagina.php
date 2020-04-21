<?php

session_start();

$title = "profielpagina";

require_once('includes/database.php');

require_once('includes/functions.php');

require_once('includes/header.php');

$profile_data = getUser($_SESSION['name']);

?>
<h2>Profielpagina</h2>

<h4>Persoonlijke gegevens:</h4><br>
<p>Gebruikersnaam: <?=$profile_data['Gebruikersnaam']?></p><br>
<p>Voornaam: <?=$profile_data['Voornaam']?></p><br>
<p>Achternaam:<?=$profile_data['Achternaam']?></p><br>
<p>Adres 1: <?=$profile_data['Adresregel_1']?></p><br>
<p>Adres 2: <?=$profile_data['Adresregel_2']?></p><br>
<p>Postcode: <?=$profile_data['Postcode']?></p><br>
<p>Plaats: <?=$profile_data['Plaatsnaam']?></p><br>
<p>Land: <?=$profile_data['Land']?></p><br>
<p>Geboortedatum: <?=$profile_data['Geboortedag']?></p><br>
<p>Email: <?=$profile_data['Mailbox']?></p><br>
<p>Wachtwoord: <?=$profile_data['Wachtwoord']?></p><br>
<p>Vraag: <?=$profile_data['Vraag']?></p><br>
<p>Verkoper: <?=$profile_data['Verkoper']?></p><br>
<p>Action: <?=$profile_data['Action']?></p><br>

<?php

require_once('includes/footer.php');

?>
