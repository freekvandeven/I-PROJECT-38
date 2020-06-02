<?php
startAutoLoader();
require_once('vendor/autoload.php');
require_once('database.php'); // database connection
require_once('more/logging.php'); // site logging
require_once('more/admin.php'); // admin tasks
include_once('more/FCM.php'); // push notifications
//include_once('more/socket.php'); // websockets

if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}
$token = $_SESSION['token'];

function registerRequest()
{
    checkVisitor();
    checkItemDate();
}

function checkPost()
{
    #check if user token is set and correct
    return !empty($_POST) && !empty($_POST['token']) && hash_equals($_SESSION['token'], $_POST['token']);
}

function checkItemDate()
{
    $items = Items::getFinishedItems();
    foreach ($items as $item) {
        $bid = Items::getHighestBid($item["Voorwerpnummer"]);
        Items::finishItem($item["Voorwerpnummer"], $bid["Gebruiker"], $bid["Bodbedrag"]);
        notifySeller($item["Verkoper"], $item['Voorwerpnummer'], $bid['Bodbedrag']);
        notifyBuyer($bid["Gebruiker"], $item['Voorwerpnummer'], $bid['Bodbedrag']);
        notifyFollowers($item["Voorwerpnummer"], "De veiling is afgelopen", "item.php?id=".$item["Voorwerpnummer"]);
    }
}

function cleanupUploadFolder()
{
    $dir = "upload/items/";
    foreach (scandir($dir, 1) as $file) {
        unlink($dir . $file);
    }

    $dir = "upload/users/";
    foreach (scandir($dir, 1) as $file) {
        unlink($dir . $file);
    }
}

function startAutoLoader()
{
    #this function loads all classes in classes/models/ whenever they are called in our program.
    spl_autoload_register(function ($class_name) {
        include 'classes/models/' . $class_name . '.php';
    });
}

function sendPushNotification()
{
    $regId = 'test';
    $notification = array();
    $arrNotification = array();
    $arrData = array();
    $arrNotification["body"] = "Test by Freek.";
    $arrNotification["title"] = "PHP ADVICES";
    $arrNotification["sound"] = "default";
    $arrNotification["type"] = 1;

    $fcm = new FCM();
    $result = $fcm->send_notification($regId, $arrNotification, "Android");
}

function displayInformation($array, $notifications)
{
    $html = "";
    if (sizeof($array) == 0) {
        if ($notifications) {
            echo '<p>Er zijn nog geen notificaties :(</p>';
        } else {
            echo '<p>Nog geen gebruikers :(</p>';
        }
    } else {
        if ($notifications) {
            foreach ($array as $notification) {
                $html .= "<a href='" . $notification['Link'] . "' class='list-group-item list-group-item-action'>" . $notification['Bericht'] . "</a>";
            }
        } else {
            foreach ($array as $user) {
                $html .= "<input type='submit' class='list-group-item list-group-item-action' name='user' value='$user'>";
            }
        }
    }
    return $html;
}

function deleteFile($file)
{
    if (file_exists($file)) {
        unlink($file);
    }
}

function createSession($user) // create session for user
{
    session_regenerate_id();
    $_SESSION['loggedin'] = TRUE;
    $_SESSION['name'] = $user['Gebruikersnaam'];
    $_SESSION['admin'] = $user['Action'];
}

function storeImg($files, $id, $target_dir)
{
    move_uploaded_file($files, $target_dir . $id . '.png');
}

function checkImageExists($fileName)
{
    return file_exists("upload/items/$fileName");
}

function getProfileImage($user)
{
    if (isset($user) && file_exists("upload/users/" . $user . ".png")) {
        return "upload/users/$user.png?" . filemtime("upload/users/$user.png");
    } else {
        return "images/profilePicture.png?";
    }
}

function sendConfirmationEmail($mail, $username, $hash)
{
    $subject = "Bevestig je account";
    $variables = [];
    $variables['username'] = $username;
    $variables['hash'] = $hash;
    return sendFormattedMail($mail, $subject, "confirm.html", $variables);
}

function notifyFollowers($item, $message)
{
    foreach (Items::getFollowers($item) as $follower) // get all item followers
    {
        User::notifyUser($follower, $message, "item.php?id=$item");
    }
}

function notifySeller($seller, $id, $price)
{
    $user = User::getUser($seller);
    $subject = "Veiling afgelopen";
    $variables = [];
    $variables["username"] = $user['Voornaam'];
    $variables['id'] = $id;
    $variables['price'] = $price;
    sendFormattedMail($user['Mailbox'], $subject, "sold.html", $variables);
    User::notifyUser($seller, "Je veiling is afgelopen", "item.php?id=$id");
}

function notifyBuyer($buyer, $id, $offer)
{
    $user = User::getUser($buyer);
    $subject = "Veiling afgelopen";
    $variables = [];
    $variables["username"] = $user['Voornaam'];
    $variables['id'] = $id;
    $variables['offer'] = $offer;
    sendFormattedMail($user['Mailbox'], $subject, "bought.html", $variables);
    User::notifyUser($buyer, "Je hebt de veiling gewonnen", "item.php?id=$id");
}

function sendFormattedMail($receiver, $subject, $filename, $variables)
{
    $template = file_get_contents("classes/views/email/" . $filename);
    foreach ($variables as $key => $value) {
        $template = str_replace('{{ ' . $key . ' }}', $value, $template);
    }
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=utf-8\r\n";
    return mail($receiver, $subject, $template, $headers);
}

function generateImageLink($item, $thumbnail = true)
{
    if ($thumbnail) {
        $image = Items::getThumbnail($item);
        if (strpos($image, 'cst') !== false) { // file exists doesn't work on the files in thumbnails
            return "upload/items/" . $image;
        } else {
            return "thumbnails/" . $image;
        }
    } else {
        $images = Items::getFiles($item);
        if (strpos($images[0], 'cst') !== false) { // file exists doesn't work on the files in pics
            return preg_filter('/^/', 'upload/items/', $images);
        } else {
            return preg_filter('/^/', 'pics/', $images);
        }
    }
}

function generateCatalog($items, $counter = 0, $new = false)
{
    foreach ($items as $card):
        if ($counter % 4 == 0) {
            echo "<div class='row'>";
        }
        ?>
        <div class='col-xl-3 col-6'>
            <div class='card'>
                <div class="itemImageCatalogusPage">
                    <a href='item.php?id=<?= $card['Voorwerpnummer'] ?>'>
                        <img src='<?php echo generateImageLink($card['Voorwerpnummer'], true); ?>' class='card-img-top'
                             alt='Productnaam'>
                        <!--<img src='upload/items/<?= $card["Voorwerpnummer"] ?>.png' class='card-img-top' alt='Productnaam'>-->
                    </a>
                </div>
                <div class='card-body'>
                    <h5 class='card-title'><?= $card['Titel'] ?></h5>
                    <p class='card-text'><?php if (strlen($card['Beschrijving']) < 200) $card['Beschrijving'] ?></p>
                    <p class="card-text"> &euro; <?= number_format($card['prijs'], 2, ',', '.') ?></p>
                    <a href='item.php?id=<?= $card['Voorwerpnummer'] ?>' class='card-link'>Meer informatie</a>
                </div>
                <div class='card-footer'>
                    <!-- Display the countdown timer in an element -->
                    <p id="timer-<?= $counter ?>"></p>
                    <?php if ($new): ?>
                        <p><?= timeRemaining($card['LooptijdBeginTijdstip']); ?></p>
                    <?php endif; ?>
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

function timeRemaining($startTime)
{
    $timeRemaining = round((strtotime(date('Y-m-d H:i:s')) - strtotime($startTime)) / 60, 0);
    $negative = ($timeRemaining>0)?0:1;
    $timeRemaining = abs($timeRemaining);
    if ($timeRemaining>=60) {
        $hours = floor($timeRemaining / 60);
        $timeRemaining = $hours." uur";
        if ($hours>=24  ) {
            $days = floor($hours / 24);
            $timeRemaining = $days." dagen";
        }
    }else{
       return "$timeRemaining minuten geleden!";
    }
    if($negative){
        return "Veiling opent over $timeRemaining";
    }
    return $timeRemaining." geleden";
}

function reOrganizeArray($file_posts)
{
    $new_file_array = array();
    $file_count = count($file_posts['name']);
    $file_keys = array_keys($file_posts);

    for ($i = 0; $i < $file_count; $i++) {
        foreach ($file_keys as $key) {
            $new_file_array[$i][$key] = $file_posts[$key][$i];
        }
    }
    return $new_file_array;
}
function generateCategoryArray()
{
    $result = Category::getCategories();
    $filtered = [];
    $mapping = [];
    foreach ($result as $row) {
        $filtered[$row['hoofdnummer']][$row['subnummer']][$row['subsubnummer']][] = $row['subsubsubnummer'];
        $mapping[$row['hoofdnummer']] = $row['hoofdnaam'];
        $mapping[$row['subnummer']] = $row['subnaam'];
        $mapping[$row['subsubnummer']] = $row['subsubnaam'];
        $mapping[$row['subsubsubnummer']] = $row['subsubsubnaam'];
    }
    return array($filtered, $mapping);
}
function generateCategoryDropdown()
{
    $categories = Category::getCategories();
    $html = '<ul>';
    foreach ($categories as $maincategory => $subcategories) {
        $html .= "<li>$maincategory<ul>";
        foreach ($subcategories as $subcategory => $subsubcategories) {
            $html .= "<li>$subcategory";
            if (!empty($subsubcategories[0])) {
                $html .= "<ul>";
                foreach ($subsubcategories as $subsubcategory) {
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

function evalSelectPOST()
{
    $select = array();
    $distance = false;
    if (isset($_POST)) {
        if ((isset($_SESSION['name'])&&(isset($_POST['maximumDistance'])&&$_POST['maximumDistance']!=800)) || !empty($_POST['postalCode'])) {                           /////////postal code input////////
            $distance = true;
            $select[':minimumDistance'] = isset($_POST['minimumDistance']) ? $_POST['minimumDistance'] : 0; // min distance 0 if post isn't set
            $select[':maximumDistance'] = $_POST['maximumDistance'];
            $select = setLatLong($select);
        }
        if (isset($_POST['search'])) {                                                           /////////search input//////////
            $keywords = explode(" ", $_POST['search']);
            $temp = [];
            foreach ($keywords as $keyword) {
                $keyword = preg_replace('/\PL/u', '', $keyword);
                if ($keyword != "") $temp[] = $keyword;
            }
            $keywords = $temp;
            $select[':search'] = $keywords;
        }                                                                                         ///////// price between////////
        if (!empty($_POST['minimum']) && $_POST['minimum'] > 1 && $_POST['minimum'] < 1000000) {
            $select[':val1'] = $_POST['minimum'];
        } else {
            $select[':val1'] = 1;
        }
        if (!empty($_POST['maximum']) && $_POST['maximum'] > 1 && $_POST['maximum'] < 1000000) {
            $select[':val2'] = $_POST['maximum'];
        } else {
            $select[':val2'] = 1000000;
        }
        if (isset($_POST['rubriek'])) {
            $select[":rubriek"] = $_POST['rubriek'];
        }
        if (isset($_GET['rubriek'])) {
            $select[":rubriek"] = $_GET['rubriek'];
        }
        if (isset($_POST['order'])) {                                                             /////// order by ///////////
            switch ($_POST['order']) {
                case "Low":
                    $select[':order'] = "prijs ASC";
                    break;
                case "High":
                    $select[':order'] = "prijs DESC";
                    break;
                case "New":
                    $select[':order'] = "abs(datediff_BIG(second,looptijdbegintijdstip, getdate())) ASC";
                    break;
                case "Old":
                    $select[':order'] = "abs(datediff_BIG(second,looptijdbegintijdstip, getdate())) DESC";
                    break;
                case "Dis":
                    if (!$distance) {
                        $select = setLatLong($select);
                    }
                    $select[':order'] = $_POST['order'];
                    break;
                default:
                    $select[':order'] = "n";
                    break;
            }
        } else {
            $select[':order'] = "n";
        }
        if (isset($_POST['offset'])) {
            $select[':offset'] = $_POST['offset'];
        } else {
            $select[':offset'] = " ";
        }                                                                                            ///////// limit /////////
        if (isset($_POST['numberOfItems']))
            switch ($_POST['numberOfItems']) {
                case "24":
                    $select[':limit'] = "24";
                    break;
                case "48":
                    $select[':limit'] = "48";
                    break;
                case "96":
                    $select[':limit'] = "96";
                    break;
                case "10000":
                    $select[':limit'] = "10000";
                    break;
                default:
                    $select[':limit'] = "25";
            }
        else {
            $select[':limit'] = "24";
        }
    } else {
        $select[':val1'] = 1;
        $select[':val2'] = 1000000;
    }
    return $select;
}

function setLatLong($select)
{
    if (!empty($_POST['postalCode']) && $_SESSION['postalCode'] != $_POST['postalCode']) {
        $location = calculateLocation($_POST['postalCode']);
        $select[':lat'] = $location['latitude'];
        $select[':long'] = $location['longitude'];
        $_SESSION['postalCode'] = $_POST['postalCode'];
        $_SESSION['latitude'] = $location['latitude'];
        $_SESSION['longitude'] = $location['longitude'];
    } elseif (isset($_SESSION['postalCode']) && $_SESSION['postalCode'] == $_POST['postalCode']) {
        $select[':lat'] = $_SESSION['latitude'];
        $select[':long'] = $_SESSION['longitude'];
    } elseif (!empty($_SESSION['name'])) {
        $user = User::getUser($_SESSION['name']);
        $select[':lat'] = $user['Latitude'];
        $select[':long'] = $user['Longitude'];
    }
    return $select;
}
