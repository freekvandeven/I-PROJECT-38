<?php
$profile_data = getUser($_SESSION['name']);
?>


<main>
    <h1>Update profiel</h1>
    <form method="POST" action="">
        <input type="hidden" name="action" value="update">
        <label for="gebruikersnaam">Gebruikersnaam</label>
        <input type="text" name="username" id="gebruikersnaam" value="<?=$profile_data['Gebruikersnaam']?>" required> <br>
        <label for="wachtwoord"> Wachtwoord</label>
        <input type="password" name="password"  id="wachtwoord" value="<?php$profile_data['Wachtwoord']?>"required><br>
        <label for= "email-adres">Email</label>
        <input type="email" name="email" id="email-adres" value="<?=$profile_data['Mailbox']?>" required> <br>
        <label for= "voornaam">Voornaam</label>
        <input type="text" name="first-name" id="voornaam" value="<?=$profile_data['Voornaam']?>" required> <br>
        <label for= "achternaam">Achternaam</label>
        <input type="text" name="surname" id="achternaam" value="<?=$profile_data['Achternaam']?>" required> <br>
        <label for= "adres">Adres</label>
        <input type="text" name="adress" id="adres" value="<?=$profile_data['Adresregel_1']?>" required> <br>
        <label for= "postcode">Postcode</label>
        <input type="text" name="postcode" id="postcode" value="<?=$profile_data['Postcode']?>"required> <br>
        <label for= "plaats">Plaats</label>
        <input type="text" name="place" id="plaats" value="<?=$profile_data['Plaatsnaam']?>" required> <br>
        <label for= "land">Land</label>
        <input type="text" name="country" id="land" value="<?=$profile_data['Land']?>" required> <br>
        <label for= "telefoonnummer">Telefoonnummer</label>
        <input type="text" name="phone-number" id="telefoonnummer" required> <br>
        <label for= "telefoonnummer2">Telefoonnummer 2</label>
        <input type="text" name="phone-number2" id="telefoonnummer2"> <br>
        <label for= "geboortedatum">Geboortedatum</label>
        <input type="date" name="birthdate" id="geboortedatum" value="<?=$profile_data['Geboortedag']?>" > <br>
        <label for= "geheime-vraag">Geheime vraag</label>
        <input type="text" name="secret-question" id="geheime-vraag" value=" <?=$profile_data['Vraag']?>" required> <br>
        <label for= "geheim-antwoord">Geheim antwoord</label>
        <input type="text" name="secret-answer" id="geheim-antwoord" value="<?=$profile_data['Antwoordtekst']?>" required> <br>
        <input type="submit" name="Verzenden" value="Verzenden">
    </form>
    <a href="profile.php">Ga terug</a>
</main>
