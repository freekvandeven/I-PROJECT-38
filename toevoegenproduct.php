<?php

session_start();

$title = "toevoegenproduct";

require_once('includes/database.php');

require_once('includes/functions.php');

require_once('includes/header.php');

checkLogin();

?>

<form method="POST"> 

    <label for="Titel">Titel voorwerp: </label>
    <input type="text" name="title_product" id="Titel" required> <br>

    <label for="Beschrijving">Beschrijving: </label>
    <input type="text" name="description_product" id="Beschrijving" required><br>

    <label for="Rubriek">Rubriek: </label>
    <select id="Rubriek" name="categorie" required>
        <option value="Auto's, boten en motoren">Autos, boten en motoren</option>
        <option value="Baby">Baby</option>
        <option value="Muziek en Instrumenten">Muziek en instrumenten</option>
        <option value="Elektronica">Elektronica</option>
        <option value="Mode">Mode</option>
    </select><br>
    
	<label for=img>Select image: </label> 
	<input type=file id=img name=img accept=image/*> <br> 

    <label for="Startprijs">Startprijs: </label>
    <input type="number" name="starting_price_product" id="Startprijs" required><br>

    <label for="Betalingswijze">Betalingswijze: </label>
    <select id="Betalingswijze" name="payment_method_product" required>
        <option value="Contact">Contact</option>
        <option value="Bank">Bank</option>
        <option value="Anders">Anders</option>
    </select> <br>

    <label for="Betalingsinstructies">Betalingsinstructies: </label>
    <input type="text" name="payment_instructions" id="Betalingsinstructies"><br>

    <label for="Looptijd">Looptijd: </label>
    <select id="Looptijd" name="duration" required>
        <option value="1">1</option>
        <option value="3">3</option>
        <option value="5">5</option>
        <option value="7" selected="selected">7</option>
        <option value="10">10</option>
    </select><br>

    <label for="Verzendinstructies">Verzendinstructies: </label>
    <input type="text" name="payment_instructions" id="Verzendinstructies"><br>

    <input type="submit" name="submit" value="Verzenden">
</form>  

<?php

require_once('includes/footer.php');

?>
