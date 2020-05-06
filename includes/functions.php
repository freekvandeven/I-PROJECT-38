<?php
startAutoLoader();
require_once('database.php');
checkVisitor();
checkItemDate();

function checkLogin()
{
    if (!isset($_SESSION['loggedin'])) {
        header('Location: login.php');
        exit();
    }
}

function checkItemDate(){
    $items = Items::getFinishedItems();
    foreach($items as $item){
        $bid = Items::getHighestBid($item["Voorwerpnummer"]);
        Items::finishItem($item["Voorwerpnummer"],$bid["Gebruiker"],$bid["Bodbedrag"]);
        notifySeller($item["Verkoper"]);
        notifyBuyer($bid["Gebruiker"]);
    }
}

function checkVisitor(){
    logPageVisitor();
    checkIP();
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
    if(checkBlacklist($_SERVER["REMOTE_ADDR"])){
        header("Location: 404.php");
    }
}


function checkAdminLogin()
{
    if (!isset($_SESSION['admin']) || !$_SESSION['admin']) {
        header('Location: index.php');
        exit();
    }
}

function createSession($user)
{
    session_regenerate_id();
    $_SESSION['loggedin'] = TRUE;
    $_SESSION['name'] = $user['Gebruikersnaam'];
    $_SESSION['admin'] = $user['Action'];
}

function setupDatabase()
{
    global $dbh;
    $sql = file_get_contents('includes/Testscript.sql');
    $data = $dbh->exec($sql);
}

function storeImg($id,$target_dir)
{
    move_uploaded_file($_FILES['img']['tmp_name'], $target_dir . $id .'.png');
}

function sendConfirmationEmail($mail, $username)
{
    $subject = "Bevestig je account";
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=utf-8\r\n";
    $message = "<html><body>
                <p>Hallo $username,</p>
                <p>Welkom bij EenmaalAndermaal</p>
                <p>Om de website te kunnen gebruiken moet je op onderstaande link klikken om de account te activeren</p>
                <a href='https://iproject38.icasites.nl/login.php?name=$username' tartget='_blank'>Activeer je account</a>
                </body></html>";
    return mail($mail, $subject, $message, $headers);
}

function notifySeller($seller){
    $user = User::getUser($seller);
    $subject = "Veiling afgelopen";
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=utf-8\r\n";
    $message = "<html><body>
                <p>Je veiling is afgelopen.</p>

                </body></html>";
    mail($user['Mailbox'], $subject, $message, $headers);
}

function notifyBuyer($buyer){
    $user = User::getUser($buyer);
    $subject = "Veiling afgelopen";
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=utf-8\r\n";
    $message = "<html><body>
                <p>Je hebt de veiling gewonnen.</p>
                </body></html>";
    mail($user['Mailbox'], $subject, $message, $headers);
}
