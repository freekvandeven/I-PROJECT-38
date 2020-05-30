<?php
session_start();
require_once('includes/functions.php');


$title = 'test page';

require_once('includes/header.php');

//phpinfo();

$file = 'SQL/9800-Auto\'s, motoren en boten/9884-Autoaccessoires en onderdelen.sql';
$nummer = 11968;
/*
$test = $dbh->prepare("{CALL fileInsert(?, ?)}");
$test->bindParam(1, $file, PDO::PARAM_STR);
$test->bindParam(2, $nummer, PDO::PARAM_INT);
$test->execute();
print_r($test->errorInfo());

$dirs = array_filter(glob('SQL/*'), 'is_dir');
$files = [];
foreach($dirs as $dir){
    $files = array_merge($files, preg_filter('/^/', $dir . "/",array_diff(scandir($dir,1), array('.', '..'))));
}
var_dump($files);
*/
/*
$voorwerpInsert = $dbh->prepare("INSERT INTO Voorwerp (Titel, Beschrijving, Startprijs, Betalingswijze, Plaatsnaam, Land, LooptijdBeginTijdstip, Verzendkosten,Verzendinstructies, Verkoper, LooptijdEindeTijdstip, VeilingGesloten) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$voorwerpRubriek = $dbh->prepare("INSERT INTO VoorwerpInRubriek (Voorwerp, RubriekOpLaagsteNiveau) VALUES (?, ?)");
$imageInsert = $dbh->prepare("{CALL fileInsert(?, ?)}");
$imageInsert->bindParam(1, $imageFile, PDO::PARAM_STR, 40);
$imageInsert->bindParam(2, $itemID, PDO::PARAM_INT);


$fileText = file_get_contents($file);
echo strlen($fileText);
# step 4.3 Split file into items
$splitFile = explode("INSERT Items", $fileText);


//echo '<pre>' , print_r($splitFile) , '</pre>';
# step 4.4 split on item parts
$i=0;
array_shift($splitFile);
foreach ($splitFile as $item) {
    echo "test";
    $i++;
    if($i>200)die("testeinde");
    echo $i;

    $splitParts = explode("INSERT", $item);
    //array_shift($splitParts);

    # step 4.5 insert item
    $itemInsertParts = explode(") VALUES (", $splitParts[0]);
    $output = preg_split("/(\'\,\'|\'\,|\,\')/", $itemInsertParts[1]);


    $voorwerpNummer = $output[0];
    $titel = $output[1];
    $category = $output[2];
    $postcode = $output[3];
    $locatie = $output[4];
    $land = $output[5];
    $verkoper = $output[6];
    $prijs = calculateCurrency($output[7], $output[8]);
    $beschrijving = $output[11];
    $currencies[] = $output[8];
    $imageFile = $output[10];

    $voorwerpInsert->execute(array($titel, substr(removeBadElements($beschrijving), 0, 4000), $prijs, "niks", $locatie, $land, '2020-06-20 12:00:00:000', 5.00, 'testinstructie', $verkoper, '2020-06-30 12:00:00:000', FALSE));
    $itemID = Items::get_ItemId();

    $voorwerpRubriek->execute(array($itemID, $category));
    echo print_r($voorwerpInsert->errorInfo());

    //$imagelink = str_replace("img", "dt_1_", $output[10]);
    //store file with new autoincrementId as id.png
    //imagepng(imagecreatefromstring(file_get_contents('https://iproject38.icasites.nl/thumbnails/' . $output )), 'upload/items/' . $itemID . '.png');
    $imageInsert->execute();
    echo print_r($imageInsert->errorInfo());
    //Items::insertFile(array(":Filenaam"=>$output[10],":Voorwerp"=>$itemID));

    # step 4.6 insert images in bestanden
    array_shift($splitParts); // remove first insert for item


    foreach ($splitParts as $image) {
        # put image into database
        $imageFile = explode('\'', $image)[1];
        $imageInsert->execute();
        echo print_r($imageInsert->errorInfo());
        //$imageInsert->execute(array(":Filenaam"=>$imageName,":Voorwerp"=>$itemID));
        //Items::insertFile(array(":Filenaam"=>$imageName,":Voorwerp"=>$itemID));
    }

}

*/


//cleanupUploadFolder();

$data = $dbh->prepare("SELECT TOP 10 Beschrijving FROM Voorwerp ORDER BY LEN(Beschrijving) DESC");
$data->execute();
$result = $data->fetchAll(PDO::FETCH_COLUMN);
var_dump($result);
//var_dump(array(htmlentities($result[0]),htmlentities($result[1]),htmlentities($result[2])));
//var_dump(array(removeBadElements($result[0]),removeBadElements($result[1]),removeBadElements($result[2])));


//setupProcedures();
//var_dump(getRandomUserData());

function removeBadElements($input)
{ // remove all bad characters
    preg_replace('/(<script[^>]*>.+?<\/script>|<style[^>]*>.+?<\/style>)/s', '', $input);
    $doc = new DOMDocument();
    $doc->loadHTML($input);

    //removeElementsByTagName('script', $doc);
    $input = strip_tags($input, '<p><a><h1><h2><h3><h4><h5><br><b><i>');
    return $input;
}

function getRandomUserData(){
    $firstnames = ["Piet", "Jan", "Winter", "Zwaluw", "Maan", "Ster", "Zomer"];
    $surname = ["cohen", "frank", "Polak", "de Vries", "de Jong", "de Leeuw"];
    $emails = ["test@hotmail.com", "hallo@gmail.com", "xtc@yahoo.com"];
    $city = ['Ruinerwold', 'Barnevelt', 'Gent', 'Hatert'];
    return [$firstnames[array_rand($firstnames)],$surname[array_rand($surname)],$emails[array_rand($emails)], $city[array_rand($city)]];
}

/*
$doc->loadHTML($a);
$list = $doc->getElementsByTagName("p");

while ($list->length > 0) {
    $p = $list->item(0);
    $p->parentNode->removeChild($p);
}
*/

function calculateCurrency($amount, $currency)
{
    $multiplier = 1.0;
    if ($currency == 'USD') {
        $multiplier = 0.92;
    } else if ($currency == 'GBP') {
        $multiplier = 1.14;
    }
    return $amount * $multiplier;
}







//echo calculateDistance(calculateLocation('6671GK'),calculateLocation('6525EC'));
//echo generateCategoryDropdown();
require_once('includes/footer.php');
?>