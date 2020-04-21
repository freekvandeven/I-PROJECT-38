<!Doctype HTML>
<html lang="nl">
    <head>
        <title>Amos Middelkoop</title>
        <meta charset="UTF-8">
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <link rel="stylesheet" href="CSS/styles.css">
    </head>
    <body>
<form method="POST" action="inlogvalidatie.php"> 

    <label for="Titel">Titel voorwerp</label>
    <input type="text" name="title_product" id="Titel" required> <br>

    <label for="Beschrijving">Beschrijving</label>
    <input type="text" name="description_product" id="Beschrijving" required><br>

    <label for="Startprijs">Startprijs</label>
    <input type="number" name="starting_price_product" id="Startprijs" required><br>

    <label for="Betalingswijze">Betalingswijze</label>
    <select id="Betalingswijze" name="payment_method_product" required>
        <option value="Contact">Contact</option>
        <option value="Bank">Bank</option>
        <option value="Anders">Anders</option>
    </select> <br>

    <label for="Betalingsinstructies">Betalingsinstructies</label>
    <input type="text" name="payment_instructions" id="Betalingsinstructies"><br>

    <label for="Looptijd">Looptijd</label>
    <select id="Looptijd" name="duration" required>
        <option value="1">1</option>
        <option value="3">3</option>
        <option value="5">5</option>
        <option value="7">7</option>
        <option value="10">10</option>
    </select><br>

    <label for="Verzendinstructies">Verzendinstructies</label>
    <input type="text" name="payment_instructions" id="Verzendinstructies"><br>

    <input type="submit" name="submit" value="Submit">

</form>  

</body>

</html>

