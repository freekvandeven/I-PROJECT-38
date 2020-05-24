<?php
// check if you are admin
checkAdminLogin();
$dir = (isset($_POST["dir"])) ? $_POST["dir"] : 0;
$file = (isset($_POST["file"])) ? $_POST["file"] : 0;

$dirs = array_filter(glob('SQL/*'), 'is_dir');
$files = [];
foreach ($dirs as $dir) {
    $files = array_merge($files, preg_filter('/^/', $dir . "/",array_diff(scandir($dir,1), array('.', '..'))));
}

switch ($_POST["step"]) {
    case 0:
        # step 0 clear the database
        $dbh->exec("DELETE FROM Voorwerp WHERE Betalingswijze='niks'");
        $dbh->exec("DELETE FROM Gebruiker WHERE Voornaam='Testvoornaam'");
        $dbh->exec("ALTER TABLE Rubriek NOCHECK CONSTRAINT FK_ParentRubriek");
        $dbh->exec("DELETE FROM Rubriek");
        echo "Clear database\n";
        echo "busy\n";
        break;
    case 1:
        // step 1 add rubrieken
        $file = file_get_contents('SQL/CREATE Categorieen.sql');

        $refactorFile = str_replace("INSERT Categorieen (ID,Name,Parent)", "INSERT INTO Rubriek (Rubrieknummer, Rubrieknaam, Rubriek)", $file);
        #step 1.3 split file in inserts
        $delimited = explode("\n", $refactorFile);
        $inserts = array_slice($delimited, 2);
        #step 1.4 loop over inserts
        foreach ($inserts as $insert) {
            $dbh->query($insert);
        }
        #step 1.5 reapply constraint
        $dbh->exec("ALTER TABLE Rubriek CHECK CONSTRAINT FK_ParentRubriek");
        echo "Create categories\n";
        echo "busy\n";
        break;
    case 2:
        // turn off constraint
        $dbh->exec("ALTER TABLE Voorwerp NOCHECK CONSTRAINT FK_Voorwerp_Gebruiker_Verkoper");
        $dbh->exec("SET ANSI_WARNINGS OFF");
        echo "Turning off constraints\n";
        echo "busy\n";
        break;
    case 27:
        // deze stap werkt niet, doe niks
        echo "Processing file\n";
        echo "busy\n";
        break;
    default:
        echo "Progressing file\n";
        if (($_POST["step"] - 3) >= count($files)) {
            // turn on constraint
            $dbh->exec("ALTER TABLE Voorwerp CHECK CONSTRAINT FK_Voorwerp_Gebruiker_Verkoper");
            $dbh->exec("SET ANSI_WARNINGS ON");
            echo "finished\n";
        } else {
            $file = $files[$_POST["step"] - 3];
            if (strpos($file,"CREATE Users.sql") !== false) {
                # step 3 insert the new users

                # step 3.1 get the file
                $userFile = file_get_contents($file);
                #step 3.2 fix insert string
                $refactorFile = str_replace("INSERT Users (Username,Postalcode,Location,Country,Rating) VALUES (",
                    "INSERT INTO Gebruiker (Voornaam, Achternaam, Plaatsnaam, Adresregel_1, Geboortedag, Mailbox, Wachtwoord, Latitude, Longitude, Vraag, Verkoper, Action, Bevestiging, Gebruikersnaam,Postcode,Land,Antwoordtekst) VALUES ('Testvoornaam', 'Testachternaam','Zetten', 'Adminlaan','2000-01-01','test@hotmail.com','testwachtwoord',52.718239,6.267012,1,1, 1, 1,", $userFile);
                # step 3.3 split file in inserts
                $inserts = explode("\n", $refactorFile);

                # step 3.4 loop over inserts

                foreach ($inserts as $insert) {

                    $dbh->query(substr($insert, 0, strrpos($insert, ",")) . ')');
                }
            }
            else {
                // setup procedures
                $voorwerpInsert = $dbh->prepare("INSERT INTO Voorwerp (Titel, Beschrijving, Startprijs, Betalingswijze, Plaatsnaam, Land, LooptijdBeginTijdstip, Verzendkosten,Verzendinstructies, Verkoper, LooptijdEindeTijdstip, VeilingGesloten) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $voorwerpRubriek = $dbh->prepare("INSERT INTO VoorwerpInRubriek (Voorwerp, RubriekOpLaagsteNiveau) VALUES (?, ?)");
                $imageInsert = $dbh->prepare("exec fileInsert ?, ?");
                $imageInsert->bindParam(1, $imageFile);
                $imageInsert->bindParam(2, $itemID);

                $fileText = file_get_contents($file);
                # step 4.3 Split file into items
                $splitFile = explode("INSERT Items", $fileText);
                # step 4.4 split on item parts
                array_shift($splitFile);
                foreach ($splitFile as $item) {
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

                    //$imagelink = str_replace("img", "dt_1_", $output[10]);
                    //store file with new autoincrementId as id.png
                    //imagepng(imagecreatefromstring(file_get_contents('https://iproject38.icasites.nl/thumbnails/' . $output )), 'upload/items/' . $itemID . '.png');
                    $imageInsert->execute();
                    //Items::insertFile(array(":Filenaam"=>$output[10],":Voorwerp"=>$itemID));

                    # step 4.6 insert images in bestanden
                    array_shift($splitParts); // remove first insert for item


                    foreach ($splitParts as $image) {
                        # put image into database
                        $imageFile = explode('\'', $image)[1];
                        $imageInsert->execute();
                        //$imageInsert->execute(array(":Filenaam"=>$imageName,":Voorwerp"=>$itemID));
                        //Items::insertFile(array(":Filenaam"=>$imageName,":Voorwerp"=>$itemID));
                    }
                }
            }
            echo "busy\n";
        }
        break;
}
    //echo $_POST["step"] . "-" . count($files);
    echo round($_POST["step"]*100/(count($files)+3));


function removeBadElements($input)
{ // remove all bad characters
    //return "<iframe>" . $input . "</iframe>";
    return $input;
}

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

?>
