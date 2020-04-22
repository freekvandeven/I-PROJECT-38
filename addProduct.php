<?php

session_start();

$title = "toevoegenproduct";

require_once('includes/database.php');

require_once('includes/functions.php');

require_once('includes/header.php');
$parameterList = array("Titel", "Beschrijving", "Rubriek", "img", "Startprijs", "Betalingswijze", "Betalingsinstructie", "Looptijd",
    "Verzendinstructies");
checkLogin();
$user = getUser($_SESSION["name"]);
if ($user["Verkoper"] == "1") {
    if (isset($_POST["Titel"]) && isset($_POST["Beschrijving"]) && isset($_POST["Startprijs"]) && isset($_FILES["img"]) && isset($_POST["Verzendinstructies"])) {
        $posts = [];
        $date = date("Y-m-d");
        foreach ($parameterList as $parameter) {
            $posts[$parameter] = (isset($_POST[$parameter])) ? $_POST[$parameter] : '';
        }
        $item = array(":Titel" => $posts["Titel"], ":Beschrijving" => $posts["Beschrijving"],
            ":Startprijs" => $posts["Startprijs"], ":Betalingswijze" => $posts["Betalingswijze"],
            ":Betalingsinstructie" => $posts["Betalingsinstructie"],
            ":Plaatsnaam" => $user["Plaatsnaam"], ":Land" => $user["Land"],
            ":Looptijd" => $posts["Looptijd"], ":LooptijdBeginDag" => $date,
            ":LooptijdBeginTijdstip" => date("H:i:s"),
            ":Verzendkosten" => 5, ":Verzendinstructies" => $posts["Verzendinstructies"], ":Verkoper" => $user["Gebruikersnaam"],
            ":LooptijdEindeDag" => date('Y-m-d', strtotime($date . ' + ' . $_POST['Looptijd'] . ' days')),
            ":LooptijdEindeTijdstip" => date("H:i:s"), ":VeilingGesloten" => "Nee", ":Verkoopprijs" => $posts["Startprijs"]);
        //insert into db
        insertItem($item);
        // if not png
        if ($_FILES['img']['type'] != 'image/png') {
            //convert to png
            imagepng(imagecreatefromstring(file_get_contents($_FILES['img']['tmp_name'])), 'uploads/items/tempItem.png');
        }
        //store file with new autoincrementId as id.png
        storeImg(get_ItemId());
        header("Location: profile.php"); // send person to his item page
    } else {
        echo "please fill in all the data!";
    }
} else header("Location: profile.php"); // send to verkoperworden.php
?>
<main>
    <form method="POST" enctype="multipart/form-data">

        <label for="Titel">Titel voorwerp: </label>
        <input type="text" name="Titel" id="Titel" required> <br>

        <label for="Beschrijving">Beschrijving: </label>
        <input type="text" name="Beschrijving" id="Beschrijving" required><br>

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
        <input type="number" name="Startprijs" id="Startprijs" required><br>

        <label for="Betalingswijze">Betalingswijze: </label>
        <select id="Betalingswijze" name="Betalingswijze" required>
            <option value="Contact">Contact</option>
            <option value="Bank">Bank</option>
            <option value="Anders">Anders</option>
        </select> <br>

        <label for="Betalingsinstructie">Betalingsinstructie: </label> <!-- verander naar Betalingsinstructies met een S-->
        <input type="text" name="Betalingsinstructie" id="Betalingsinstructie"><br>

        <label for="Looptijd">Looptijd: </label>
        <select id="Looptijd" name="Looptijd" required>
            <option value="1">1</option>
            <option value="3">3</option>
            <option value="5">5</option>
            <option value="7" selected="selected">7</option>
            <option value="10">10</option>
        </select><br>

        <label for="Verzendinstructies">Verzendinstructies: </label>
        <input type="text" name="Verzendinstructies" id="Verzendinstructies"><br>

        <input type="submit" name="submit" value="Verzenden">
    </form>
</main>
<?php
require_once('includes/footer.php');
?>
