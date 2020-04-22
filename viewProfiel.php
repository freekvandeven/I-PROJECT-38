<?php
$profile_data = getUser($_SESSION['name']);
?>

<main>
    <form method="POST" action="">
        <input type="submit" value="Edit" name="Edit">
    </form>
    <p>Gebruikersnaam: <?=$profile_data['Gebruikersnaam']?></p> 
    <p>Voornaam: <?=$profile_data['Voornaam']?></p> 
    <p>Achternaam: <?=$profile_dat['Achternaam']?></p> 
    <p>Adres 1: <?=$profile_data['Adresregel_1']?></p> 
    <p>Adres 2: <?=$profile_data['Adresregel_2']?></p> 
    <p>Postcode: <?=$profile_data['Postcode']?></p> 
    <p>Plaatsnaam: <?=$profile_data['Plaatsnaam']?></p> 
    <p>Land: <?=$profile_data['Land']?></p> 
    <p>Geboortedag: <?=$profile_data['Geboortedag']?></p> 
    <p>Mailbox: <?=$profile_data['Mailbox']?></p> 
    <p>Wachtwoord: <?=$profile_data['Wachtwoord']?></p> 
    <p>Vraag: <?=$profile_data['Vraag']?></p> 
    <p>Antwoordtekst: <?=$profile_data['Antwoordtekst']?></p> 
    <p>Verkoper: <?=$profile_data['Verkoper']?></p> 
</main>

<?php
require_once('includes/footer.php');
?>
    

