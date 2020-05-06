<?php
session_start();
require_once('includes/functions.php');

if(!empty($_GET) && isset($_GET['id'])) {
    $item = Items::getItem($_GET['id']);
    $profile_data = User::getUser($item['Verkoper']);
    $bids = Items::getBids($_GET['id']);
?>
    <button id='btn'>Klik om alle reviews te bekijken! </button>
    <ul id="list">
        <li>Amos: een kwalitatief uitstekend product, maar ben wel 100 miljoen kwijt</li>
        <li>Joons: hallo ik ben joons en ik kief met mijn matties</li>
        <li>Freek: hallo ik ben freek joo it is your homie</li>
        <li>Anthony: joo ik ben anthony en ik houd van lekker zuupen</li>
    </ul>

    <script>
        const button = document.getElementById("btn");
        const list = document.getElementById("list");

        list.style.display = "none";

        button.addEventListener("click", (event) => {
            if(list.style.display == "none"){
                list.style.display = "block";
            } else {
                list.style.display = "none";
            }
        })
    </script>

    <?php
    if(!empty($_POST) && isset($_POST['Verzenden'])){
            echo 'Bedankt voor uw feedback!';
            echo "Uw beoordeling was: ";
            echo $_POST['rate'];
            Database::rateSeller($profile_data['Gebruikersnaam'],$_POST['rate']);
        } else {
            require_once 'starView.php';
        }

} else {
    header('Location : catalogus.php');
}

$title = "Item Page";

require_once('includes/header.php');

require_once('classes/views/itemView.php');

require_once('includes/footer.php');