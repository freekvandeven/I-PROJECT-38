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
    insertVisitorIP($_SERVER["REMOTE_ADDR"]);
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
                <a href='item.php?id=<?= $card['Voorwerpnummer'] ?>'>
                    <img src='upload/items/<?= $card['Voorwerpnummer'] ?>.png' class='card-img-top'
                         alt='Productnaam'>
                </a>
                <div class='card-body'>
                    <h5 class='card-title'><?= $card['Titel'] ?></h5>
                    <p class="card-text">	&euro; <?= number_format($card['prijs'],2, ',', '.')?></p>
                    <p class='card-text'><?php if(strlen($card['Beschrijving'])<200) echo $card['Beschrijving']; ?></p>
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