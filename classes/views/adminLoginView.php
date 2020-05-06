<h2>Inlog voor beheerder</h2>

<main>
    <form method="POST" action="">
        <input type="hidden" name="token" value="<?=$token?>">
        <label for="gebruikersnaam">Gebruikersnaam</label>
        <input type="text" name="username" id="gebruikersnaam" required> <br>
        <label for="wachtwoord"> Wachtwoord</label>
        <input type="password" name="password"  id="wachtwoord" required><br>
        <input type="submit" name="submit" value="Submit">
    </form>
</main>