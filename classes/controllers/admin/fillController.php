<?php

# code for filling database with items

/*
# step 1 add categories

$file = file_get_contents('SQL/CREATE Categorieen.sql');

#step 1.1 remove constraint

$dbh->exec("ALTER TABLE Rubriek NOCHECK CONSTRAINT FK_ParentRubriek");
$dbh->exec("DELETE FROM Rubriek");
#step 1.2 fix insert string
$refactorFile = str_replace("INSERT Categorieen (ID,Name,Parent)", "INSERT INTO Rubriek (Rubrieknummer, Rubrieknaam, Rubriek)", $file);
#step 1.3 split file in inserts
$delimited = explode("\n", $refactorFile);
$inserts = array_slice($delimited, 2);
#step 1.4 loop over inserts
foreach($inserts as $insert){
    $dbh->query($insert);
}
#step 1.5 reapply constraint
$dbh->exec("ALTER TABLE Rubriek CHECK CONSTRAINT FK_ParentRubriek");
*/
# step 2 Loop over folders

#step 2.1 get all folders
$dirs = array_filter(glob('SQL/*'), 'is_dir');
$searched = "";
# step 2.2
foreach($dirs as $dir) {

    /*
    # step 3 insert the new users

    # step 3.1 get the file
    $userFile = file_get_contents($dir .'/CREATE Users.sql');

    #step 3.2 fix insert string
    $refactorFile = str_replace("INSERT Users (Username,Postalcode,Location,Country,Rating) VALUES (",
        "INSERT INTO Gebruiker (Voornaam, Achternaam, Plaatsnaam, Adresregel_1, Geboortedag, Mailbox, Wachtwoord, Vraag, Verkoper, Action, Bevestiging, Gebruikersnaam,Postcode,Land,Antwoordtekst) VALUES ('Testvoornaam', 'Testachternaam','Zetten', 'Adminlaan','2000-01-01','test@hotmail.com','testwachtwoord',3,1, 1, 1,",$userFile);
    # step 3.3 split file in inserts
    $inserts = explode("\n", $refactorFile);

    # step 3.4 loop over inserts

    foreach($inserts as $insert){

        $dbh->query(substr($insert, 0, strrpos($insert, ",")) . ')');
    }
    */
    # step 4 insert items

    # step 4.1 get filenames
    $allfiles = scandir($dir,0);
    $files = array_diff($allfiles, array('.', '..', 'CREATE Users.sql'));

    # step 4.2 loop over the files
    $dbh->exec("ALTER TABLE Voorwerp NOCHECK CONSTRAINT FK_Voorwerp_Gebruiker_Verkoper");
    $dbh->exec("DELETE FROM Voorwerp WHERE Betalingswijze='niks'");
    foreach($files as $file) {
        $searched .= "   " . $dir . "/" . $file;

        #INSERT Items(ID,Titel,Categorie,Postcode,Locatie,Land,Verkoper,Prijs,Valuta,Conditie,Thumbnail,Beschrijving) VALUES (120668876689,'DEN BOL Fly High Quart Pole Wakeboard + Wasserski Tower Zugstange Edelstahl neu ',14385,'67547','Duitsland','DE','hausboot56','699.0','EUR','Nieuw','img120668876689.jpg','<p align="center"><font face="Times" size="5"><strong>DEN BOL Fly High Quart Pole </strong></font></p>
        $file = file_get_contents($dir . "/" . $file);

        # step 4.3 Split file into items
        $splitFile = explode("INSERT Items",$file);
        //$refactorFile = str_replace("INSERT Items(ID,Titel,Categorie,Postcode,Locatie,Land,Verkoper,Prijs,Valuta,Conditie,Thumbnail,Beschrijving)", "INSERT INTO Voorwerp(Voorwerpnummer,Titel,)",$file);

        # step 4.4 split on item parts
        array_shift($splitFile);
        foreach($splitFile as $item) {
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
            $sql = "INSERT INTO Voorwerp (Titel, Beschrijving, Startprijs, Betalingswijze, Plaatsnaam, Land, Looptijd, LooptijdBeginDag, LooptijdBeginTijdstip, Verzendkosten,Verzendinstructies, Verkoper, LooptijdEindeDag, LooptijdEindeTijdstip, VeilingGesloten) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $data = $dbh->prepare($sql);
            $data->execute(array($titel, substr(removeBadElements($beschrijving), 0, 4000), $prijs, "niks", $locatie, $land, 10,'2020-06-20', '1900-01-01 12:00:00:000',5.00,'testinstructie',$verkoper,'2020-06-30', '1900-01-01 12:00:00:000', 'Niet'));
            $sql = "INSERT INTO VoorwerpInRubriek (Voorwerp, RubriekOpLaagsteNiveau) VALUES (?, ?)";
            $data = $dbh->prepare($sql);
            $itemID = Items::get_ItemId();
            $data->execute(array($itemID, $category));
            $imagelink = str_replace("img", "dt_1_", $output[10]);
            imagepng(imagecreatefromstring(file_get_contents('https://iproject38.icasites.nl/pics/' . $imagelink )), 'upload/items/' . $itemID . '.png');
            //store file with new autoincrementId as id.png
            //move_uploaded_file('upload/items/tempItem.png', "upload/items/" . $itemID .'.png');
            //storeImg($itemID,"upload/items/");
            die("afbeelding gemaakt");

            # step 4.6 insert images in bestanden
            array_shift($splitParts);
            foreach($splitParts as $image){


            }
        }
        die("klaar");
        //$splitSplitParts = explode(") VALUES (", $splitParts);
        //die(print_r($splitParts));
    }
}
function removeBadElements($input){

    return $input;
}
function calculateCurrency($amount, $currency){
    return $amount;
}
die($searched);


