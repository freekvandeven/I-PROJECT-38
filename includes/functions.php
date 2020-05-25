<?php
startAutoLoader();
require_once('database.php');
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

function registerRequest(){
    checkVisitor();
    checkItemDate();
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
    for($i=10000;$i<40000;$i++){
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

function displayInformation($array, $notifications){
    if(sizeof($array) == 0) {
        if($notifications) {
            echo '<p>Er zijn nog geen notificaties :(</p>';
        } else {
            echo '<p>Nog geen gebruikers :(</p>';
        }
    } else {
        if($notifications) {
            foreach ($array as $user) { ?>
                <input type="submit" class='list-group-item list-group-item-action' value="<?=$user?>"> <?php
            }
        } else {
            foreach ($array as $notification) { ?>
                <a href='#' class='list-group-item list-group-item-action'><?=$notification?></a> <?php
            }
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

function checkImageExists($fileName) {
    return file_exists("upload/items/$fileName");
}

function getProfileImage($user){
    if(isset($user) && file_exists("upload/users/".$user.".png")){
        return "upload/users/$user.png";
    } else {
        return "images/profilePicture.png";
    }
}

function calculateDistance($point1, $point2){
    // Calculate distance between latitude and longitude
    print_r($point1);
    $theta    = $point1["longitude"] - $point2["longitude"];
    $dist    = sin(deg2rad($point1["latitude"])) * sin(deg2rad($point2["latitude"])) +  cos(deg2rad($point1["latitude"])) * cos(deg2rad($point2["latitude"])) * cos(deg2rad($theta));
    $dist    = acos($dist);
    $dist    = rad2deg($dist);
    $miles    = $dist * 60 * 1.1515;

    // Convert unit and return distance
    return round($miles * 1.609344, 2).' km'; // return distance in kilometer
}

function calculateLocation($location){
    $apiKey = 'AIzaSyBt6UzzpaNgxMJPT62WvvWp5Q7DKuR9GL8';
    $formattedAddrFrom = str_replace(' ', '+', $location);

    $geocodeLoc= file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddrFrom.'&sensor=false&key='.$apiKey);
    $outputLoc = json_decode($geocodeLoc);
    if(!empty($outputLoc->error_message)){
        return $outputLoc->error_message;
    }
    return array("latitude"=> $outputLoc->results[0]->geometry->location->lat,"longitude"=>$outputLoc->results[0]->geometry->location->lng);
}

function sendConfirmationEmail($mail, $username, $hash){
    $subject = "Bevestig je account";
    $variables = [];
    $variables['username'] = $username;
    $variables['hash'] = $hash;
    return sendFormattedMail($mail, $subject, "confirm.html", $variables);
}
function notifyFollowers($item){
    foreach(Items::getFollowers($item) as $follower) // get all item followers
    {
        User::notifyUser($follower, "Er is een item geupdate");
    }
}

function notifySeller($seller, $id, $price){
    $user = User::getUser($seller);
    $subject = "Veiling afgelopen";
    $variables = [];
    $variables["username"] = $user['Voornaam'];
    $variables['id'] = $id;
    $variables['price'] = $price;
    sendFormattedMail($user['Mailbox'], $subject, "sold.html", $variables);
    User::notifyUser($seller,"Je veiling is afgelopen");
}

function notifyBuyer($buyer, $id, $offer){
    $user = User::getUser($buyer);
    $subject = "Veiling afgelopen";
    $variables = [];
    $variables["username"] = $user['Voornaam'];
    $variables['id'] = $id;
    $variables['offer'] = $offer;
    sendFormattedMail($user['Mailbox'], $subject, "bought.html", $variables);
    User::notifyUser($buyer, "Je hebt de veiling gewonnen");
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

function generateImageLink($item, $thumbnail=true){
        if($thumbnail){
            $image = Items::getThumbnail($item);
            if(strpos($image, 'cst')!==false){ // file exists doesn't work on the files in thumbnails
                return "upload/items/".$image;
            } else {
                return "thumbnails/".$image;
            }
        } else {
            $images = Items::getFiles($item);
            if(strpos($images[0], 'cst')!==false) { // file exists doesn't work on the files in pics
                return preg_filter('/^/', 'upload/items/', $images);
            } else {
                return preg_filter('/^/', 'pics/', $images);
            }
        }
}

function generateCatalog($items)
{
    $counter = 0;
    foreach ($items as $card):
        if ($counter % 4 == 0) {
            echo "<div class='row'>";
        }
        ?>
        <div class='col-xl-3 col-6'>
            <div class='card'>
                <div class="itemImageCatalogusPage">
                    <a href='item.php?id=<?= $card['Voorwerpnummer'] ?>'>
                        <img src='<?php echo generateImageLink($card['Voorwerpnummer'],true); ?>' class='card-img-top' alt='Productnaam'>
                        <!--<img src='upload/items/<?= $card["Voorwerpnummer"]?>.png' class='card-img-top' alt='Productnaam'>-->
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
        if ($counter % 4 != 0) {
            echo "</div>";
        }
}

function reOrganizeArray($file_posts){
    $new_file_array = array();
    $file_count = count($file_posts['name']);
    $file_keys = array_keys($file_posts);

    for($i=0; $i<$file_count; $i++) {
        foreach($file_keys as $key){
            $new_file_array[$i][$key] = $file_posts[$key][$i];
        }
    }
    return $new_file_array;
}

function generateCategoryDropdown(){
    $categories = Items::getCategories();
    $html = '<ul>';
    foreach($categories as $maincategory=>$subcategories){
        $html .= "<li>$maincategory<ul>";
        foreach($subcategories as $subcategory=>$subsubcategories){
            $html .= "<li>$subcategory";
            if(!empty($subsubcategories[0])) {
                $html .= "<ul>";
                foreach($subsubcategories as $subsubcategory){
                $html .= "<li>$subsubcategory</li>";
                }
                $html .= "</ul>";
            }
            $html .= "</li>";
        }
        $html .= "</ul></li>";
    }
    return $html;
}

function evalSelectPOST(){
    $select = array();
    if (isset($_POST)) {
        if (isset($_POST['search'])) {
            $select[':search'] = "%" . $_POST['search'] . "%";
        }
        if(!empty($_POST['minimum'])&&$_POST['minimum']>1&&$_POST['minimum']<1000000){
            $select[':val1'] = $_POST['minimum'];
        }else{
            $select[':val1'] =  1;
        }
        if(!empty($_POST['maximum'])&&$_POST['maximum']>1&&$_POST['maximum']<1000000) {
            $select[':val2'] = $_POST['maximum'];
        }else{
            $select[':val2'] = 1000000;
        }
        if (isset($_POST['rubriek'])) {
            $select[":rubriek"] = $_POST['rubriek'];
        }
        if (isset($_POST['order'])) {
            switch ($_POST['order']) {
                case "Low":
                    $select[':order'] = "prijs ASC";
                    break;
                case "High":
                    $select[':order'] = "prijs DESC";
                    break;
                case "New":
                    $select[':order'] = "looptijdbegintijdstip DESC";
                    break;
                case "Old":
                    $select[':order'] = "looptijdbegintijdstip ASC";
                    break;
                default:
                    $select[':order'] = "n";
                    break;
            }
        } else{ $select[':order'] = "n";}
        if (isset($_POST['offset'])) {
            $select[':offset'] = $_POST['offset'];
        } else {
            $select[':offset'] = " ";
        }
// evaluate number of items cannot be used in prepared statements so it is converted to one of the following values:
        if (isset($_POST['numberOfItems']))
            switch($_POST['numberOfItems']){
                case "25":
                    $select[':limit'] = "25";
                    break;
                case "50":
                    $select[':limit'] = "50";
                    break;
                case "100":
                    $select[':limit'] = "75";
                    break;
                case "10000":
                    $select[':limit'] = "10000";
                    break;
                default:
                    $select[':limit'] = "25";
            }
        else{
            $select[':limit'] = "25";
        }
    }else{
        $select[':val1'] =  1;
        $select[':val2'] = 1000000;
    }
    return $select;
}