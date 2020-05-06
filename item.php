<?php
session_start();
require_once('includes/functions.php');
$sent = false;
if(!empty($_POST)){
    checkLogin();
    $ref = $_POST['voorwerp'];
    if(isset($_POST["bid"]) && !empty($_POST["bid"])){
        if($_POST["bid"] > Items::getHighestBid($ref)['Bodbedrag'] && $_POST["bid"] > Items::getItem($ref)["Startprijs"]){
            Items::placeBid($ref, $_POST["bid"], $_SESSION['name']);
        }
    } else {
        $err = "bid is to low";
    }

    header("Location: item.php?id=$ref");
}
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
    header('Location: catalogus.php');
}


if (!empty($_POST) && isset($_POST['Verzenden'])) {
    $sent = true;
    echo 'Bedankt voor uw feedback!';
    echo "Uw beoordeling was: ";
    echo $_POST['rate'];
    Database::rateSeller($profile_data['Gebruikersnaam'], $_POST['rate']);
}

$title = "Item Page";

require_once('includes/header.php');

require_once('classes/views/itemView.php');

require_once('includes/footer.php');