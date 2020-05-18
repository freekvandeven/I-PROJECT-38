<?php
startAutoLoader();
require_once('database.php');
checkVisitor();
checkItemDate();
//include_once('socket.php');

if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}
$token = $_SESSION['token'];

function checkLogin() // check if user is logged in
{
    if (!isset($_SESSION['loggedin'])) {
        header('Location: login.php');
        exit();
    }
}

function checkPost()
{
    #check if user token is set and correct
    return !empty($_POST) && !empty($_POST['token']) && hash_equals($_SESSION['token'], $_POST['token']);
}

function checkItemDate(){
    $items = Items::getFinishedItems();
    foreach($items as $item){
        $bid = Items::getHighestBid($item["Voorwerpnummer"]);
        Items::finishItem($item["Voorwerpnummer"],$bid["Gebruiker"],$bid["Bodbedrag"]);
        notifySeller($item["Verkoper"], $item['Voorwerpnummer'], $bid['Bodbedrag']);
        notifyBuyer($bid["Gebruiker"], $item['Voorwerpnummer'], $bid['Bodbedrag']);
    }
}

function checkVisitor(){
    logPageVisitor();
    checkIP();
}

function cleanupUploadFolder(){
    for($i=0;$i<40000;$i++){
        if(file_exists("upload/items/".$i.".png")){
            unlink("upload/items/".$i.".png");
        }
    }
}
function startAutoLoader(){
    #this function loads all classes in classes/models/ whenever they are called in our program.
    spl_autoload_register(function ($class_name) {
        include 'classes/models/' . $class_name . '.php';
    });
}

function logPageVisitor(){
    $currentPage = basename($_SERVER['PHP_SELF']);
    if(checkPage($currentPage)){
        #increase page count
        increasePage($currentPage);
    } else {
        #insert page
        insertPage($currentPage);
    }
    // insert IP
    if(searchIPVisits($_SERVER["REMOTE_ADDR"])){
        increaseIPVisits($_SERVER["REMOTE_ADDR"]);
    } else {
        insertVisitorIP($_SERVER["REMOTE_ADDR"]);
    }
}

function checkIP(){
    if($_SERVER["REMOTE_ADDR"] != '::1') {
        if (checkBlackList($_SERVER["REMOTE_ADDR"])) {
            header("Location: includes/denied.php");
        }
        if (!checkWhiteList($_SERVER["REMOTE_ADDR"])) {
            header("Location: includes/denied.php");
        }
    }
}

function deleteFile($file){
    if(file_exists($file)){
        unlink($file);
    }
}

function checkAdminLogin() //check if person is admin
{
    if (!isset($_SESSION['admin']) || !$_SESSION['admin']) {
        header('Location: login.php');
        exit();
    }
}

function createSession($user) // create session for user
{
    session_regenerate_id();
    $_SESSION['loggedin'] = TRUE;
    $_SESSION['name'] = $user['Gebruikersnaam'];
    $_SESSION['admin'] = $user['Action'];
}

function setupDatabase() // setup the database
{
    global $dbh;
    $sql = file_get_contents('includes/Testscript.sql');
    $data = $dbh->exec($sql);
}

function storeImg($files, $id,$target_dir)
{
    move_uploaded_file($files, $target_dir . $id .'.png');
}

function calculateDistance($point1, $point2, $unit = ''){
    $apiKey = 'AIzaSyBt6UzzpaNgxMJPT62WvvWp5Q7DKuR9GL8';
    //$apiKey = 'AIzaSyBA5t_6kDT86NEzXrXQSzcaZpKLbDRzBos';
    $formattedAddrFrom = str_replace(' ', '+', $point1);
    $formattedAddrTo = str_replace(' ', '+', $point2);

    // Geocoding API request with start address
    $geocodeFrom = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddrFrom.'&sensor=false&key='.$apiKey);
    $outputFrom = json_decode($geocodeFrom);
    if(!empty($outputFrom->error_message)){
        return $outputFrom->error_message;
    }

    // Geocoding API request with end address
    $geocodeTo = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddrTo.'&sensor=false&key='.$apiKey);
    $outputTo = json_decode($geocodeTo);
    if(!empty($outputTo->error_message)){
        return $outputTo->error_message;
    }

    // Get latitude and longitude from the geodata
    $latitudeFrom    = $outputFrom->results[0]->geometry->location->lat;
    $longitudeFrom    = $outputFrom->results[0]->geometry->location->lng;
    $latitudeTo        = $outputTo->results[0]->geometry->location->lat;
    $longitudeTo    = $outputTo->results[0]->geometry->location->lng;

    // Calculate distance between latitude and longitude
    $theta    = $longitudeFrom - $longitudeTo;
    $dist    = sin(deg2rad($latitudeFrom)) * sin(deg2rad($latitudeTo)) +  cos(deg2rad($latitudeFrom)) * cos(deg2rad($latitudeTo)) * cos(deg2rad($theta));
    $dist    = acos($dist);
    $dist    = rad2deg($dist);
    $miles    = $dist * 60 * 1.1515;

    // Convert unit and return distance
    $unit = strtoupper($unit);
    if($unit == "K"){
        return round($miles * 1.609344, 2).' km';
    }elseif($unit == "M"){
        return round($miles * 1609.344, 2).' meters';
    }else{
        return round($miles, 2).' miles';
    }

}

function sendConfirmationEmail($mail, $username, $hash){
    $subject = "Bevestig je account";
    $variables = [];
    $variables['username'] = $username;
    $variables['hash'] = $hash;
    return sendFormattedMail($mail, $subject, "confirm.html", $variables);
}

function notifySeller($seller, $id, $price){
    $user = User::getUser($seller);
    $subject = "Veiling afgelopen";
    $variables = [];
    $variables["username"] = $user['Voornaam'];
    $variables['id'] = $id;
    $variables['price'] = $price;
    sendFormattedMail($user['Mailbox'], $subject, "sold.html", $variables);
}

function notifyBuyer($buyer, $id, $offer){
    $user = User::getUser($buyer);
    $subject = "Veiling afgelopen";
    $variables = [];
    $variables["username"] = $user['Voornaam'];
    $variables['id'] = $id;
    $variables['offer'] = $offer;
    sendFormattedMail($user['Mailbox'], $subject, "bought.html", $variables);
}

function sendFormattedMail($receiver, $subject, $filename, $variables){
    $template = file_get_contents("classes/views/email/".$filename);
    foreach($variables as $key => $value)
    {
        $template = str_replace('{{ '.$key.' }}', $value, $template);
    }
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=utf-8\r\n";
    return mail($receiver, $subject, $template, $headers);
}

function generateCatalog($items)
{
    $counter = 0;
    foreach ($items as $card):
        if ($counter % 4 == 0) {
            echo "<div class='row'>";
        }
        ?>
        <div class='col-lg-3'>
            <div class='card'>
                <div class="itemImage">
                    <a href='item.php?id=<?= $card['Voorwerpnummer'] ?>'>
                        <img src='upload/items/<?= $card['Voorwerpnummer'] ?>.png' class='card-img-top' alt='Productnaam'>
                    </a>
                </div>
                <div class='card-body'>
                    <h5 class='card-title'><?= $card['Titel'] ?></h5>
                    <p class='card-text'><?php if(strlen($card['Beschrijving'])<200) $card['Beschrijving']?></p>
                    <p class="card-text">	&euro; <?= number_format($card['prijs'],2, ',', '.')?></p>
                    <a href='item.php?id=<?= $card['Voorwerpnummer'] ?>' class='card-link'>Meer informatie</a>
                </div>
                <div class='card-footer'>
                    <!-- Display the countdown timer in an element -->
                    <p id="timer-<?=$counter?>"></p>
                </div>
            </div>
        </div>
        <?php
        $counter++;
        if ($counter % 4 == 0) {
            echo "</div>";
        }
    endforeach;
}