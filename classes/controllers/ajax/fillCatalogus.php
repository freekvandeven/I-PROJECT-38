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
        echo "busy";
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
        echo "busy";
        break;
    case 2:
        // turn off constraint
        $dbh->exec("ALTER TABLE Voorwerp NOCHECK CONSTRAINT FK_Voorwerp_Gebruiker_Verkoper");
        echo "busy";
        break;
    case 27:
        // deze stap werkt niet, doe niks
        echo "busy";
        break;
    default:
        if (($_POST["step"] - 3) >= count($files)) {
            // turn on constraint
            $dbh->exec("ALTER TABLE Voorwerp CHECK CONSTRAINT FK_Voorwerp_Gebruiker_Verkoper");
            echo "finished";
        } else {
            $file = $files[$_POST["step"] - 3];
            if (strpos($file,"CREATE Users.sql") !== false) {
                echo "creating users";
                # step 3 insert the new users

                # step 3.1 get the file
                $userFile = file_get_contents($file);
                echo $file;
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
                echo "creating items";
                echo $file;
                // setup procedures
                $voorwerpInsert = $dbh->prepare("INSERT INTO Voorwerp (Titel, Beschrijving, Startprijs, Betalingswijze, Plaatsnaam, Land, LooptijdBeginTijdstip, Verzendkosten,Verzendinstructies, Verkoper, LooptijdEindeTijdstip, VeilingGesloten) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $voorwerpRubriek = $dbh->prepare("INSERT INTO VoorwerpInRubriek (Voorwerp, RubriekOpLaagsteNiveau) VALUES (?, ?)");
                $imageInsert = $dbh->prepare("{CALL fileInsert(?, ?)}");
                $imageInsert->bindParam(1, $imageFile, PDO::PARAM_STR, 40);
                $imageInsert->bindParam(2, $itemID, PDO::PARAM_INT);

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
                    print_r($imageInsert->errorInfo());
                    //Items::insertFile(array(":Filenaam"=>$output[10],":Voorwerp"=>$itemID));

                    # step 4.6 insert images in bestanden
                    array_shift($splitParts); // remove first insert for item


                    foreach ($splitParts as $image) {
                        # put image into database
                        $imageFile = explode('\'', $image)[1];
                        $imageInsert->execute();
                        print_r($imageInsert->errorInfo());
                        //$imageInsert->execute(array(":Filenaam"=>$imageName,":Voorwerp"=>$itemID));
                        //Items::insertFile(array(":Filenaam"=>$imageName,":Voorwerp"=>$itemID));
                    }
                }
            }
            echo "busy";
        }
        break;
}
    echo $_POST["step"] . "-" . count($files);

/*

# step 3 setup Prepares
$voorwerpInsert = $dbh->prepare("INSERT INTO Voorwerp (Titel, Beschrijving, Startprijs, Betalingswijze, Plaatsnaam, Land, LooptijdBeginTijdstip, Verzendkosten,Verzendinstructies, Verkoper, LooptijdEindeTijdstip, VeilingGesloten) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$voorwerpRubriek = $dbh->prepare("INSERT INTO VoorwerpInRubriek (Voorwerp, RubriekOpLaagsteNiveau) VALUES (?, ?)");
$imageInsert = $dbh->prepare("{CALL fileInsert(?, ?)}");
$imageInsert->bindParam(1, $imageFile, PDO::PARAM_STR);
$imageInsert->bindParam(2, $itemID, PDO::PARAM_INT);

foreach($dirs as $dir) {

    # step 3 insert the new users

    # step 3.1 get the file
    $userFile = file_get_contents($dir .'/CREATE Users.sql');

    #step 3.2 fix insert string
    $refactorFile = str_replace("INSERT Users (Username,Postalcode,Location,Country,Rating) VALUES (",
        "INSERT INTO Gebruiker (Voornaam, Achternaam, Plaatsnaam, Adresregel_1, Geboortedag, Mailbox, Wachtwoord, Vraag, Verkoper, Action, Bevestiging, Gebruikersnaam,Postcode,Land,Antwoordtekst) VALUES ('Testvoornaam', 'Testachternaam','Zetten', 'Adminlaan','2000-01-01','test@hotmail.com','testwachtwoord',1,1, 1, 1,",$userFile);
    # step 3.3 split file in inserts
    $inserts = explode("\n", $refactorFile);

    # step 3.4 loop over inserts

    foreach($inserts as $insert){

        $dbh->query(substr($insert, 0, strrpos($insert, ",")) . ')');
    }



    # step 4 insert items

    # step 4.1 get filenames
    $allfiles = scandir($dir,0);
    $files = array_diff($allfiles, array('.', '..', 'CREATE Users.sql'));

    # step 4.2 loop over the files
    $dbh->exec("ALTER TABLE Voorwerp NOCHECK CONSTRAINT FK_Voorwerp_Gebruiker_Verkoper");
    //$dbh->exec("DELETE FROM Voorwerp WHERE Betalingswijze='niks'");

    //$files = array_diff($files, ['9939-Scooters en brommers.sql']);
    foreach ($files as $file) {
        #INSERT Items(ID,Titel,Categorie,Postcode,Locatie,Land,Verkoper,Prijs,Valuta,Conditie,Thumbnail,Beschrijving) VALUES (120668876689,'DEN BOL Fly High Quart Pole Wakeboard + Wasserski Tower Zugstange Edelstahl neu ',14385,'67547','Duitsland','DE','hausboot56','699.0','EUR','Nieuw','img120668876689.jpg','<p align="center"><font face="Times" size="5"><strong>DEN BOL Fly High Quart Pole </strong></font></p>
        $fileText = file_get_contents($dir . "/" . $file);

        # step 4.3 Split file into items

        $splitFile = explode("INSERT Items", $fileText);
        //$refactorFile = str_replace("INSERT Items(ID,Titel,Categorie,Postcode,Locatie,Land,Verkoper,Prijs,Valuta,Conditie,Thumbnail,Beschrijving)", "INSERT INTO Voorwerp(Voorwerpnummer,Titel,)",$file);

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

            $voorwerpInsert->execute(array($titel, substr(removeBadElements($beschrijving), 0, 4000), $prijs, "niks", $locatie, $land, '2020-06-20 12:00:00:000',5.00,'testinstructie',$verkoper,'2020-06-30 12:00:00:000', FALSE));
            $itemID = Items::get_ItemId();
            $voorwerpRubriek->execute(array($itemID, $category));

            //$imagelink = str_replace("img", "dt_1_", $output[10]);
            //store file with new autoincrementId as id.png
            //imagepng(imagecreatefromstring(file_get_contents('https://iproject38.icasites.nl/thumbnails/' . $output )), 'upload/items/' . $itemID . '.png');
            $imageInsert->execute(array(":Filenaam"=>$output[10],":Voorwerp"=>$itemID));
            //Items::insertFile(array(":Filenaam"=>$output[10],":Voorwerp"=>$itemID));

            # step 4.6 insert images in bestanden
            array_shift($splitParts); // remove first insert for item


            foreach ($splitParts as $image) {
                # put image into database
                $imageFile = explode('\'',$image)[1];
                $imageInsert->execute();
                //$imageInsert->execute(array(":Filenaam"=>$imageName,":Voorwerp"=>$itemID));
                //Items::insertFile(array(":Filenaam"=>$imageName,":Voorwerp"=>$itemID));
            }
        }
    }
}
$dbh->exec("ALTER TABLE Voorwerp CHECK CONSTRAINT FK_Voorwerp_Gebruiker_Verkoper");

*/
function removeBadElements($input)
{ // remove all bad characters
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
