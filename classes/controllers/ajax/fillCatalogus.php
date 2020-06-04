<?php
// check if you are admin
checkAdminLogin();
$dir = (isset($_POST["dir"])) ? $_POST["dir"] : 0;
$file = (isset($_POST["file"])) ? $_POST["file"] : 0;

$dirs = array_filter(glob('SQL/*'), 'is_dir');
$files = [];
foreach ($dirs as $dir) {
    $files = array_merge($files, preg_filter('/^/', $dir . "/", array_diff(scandir($dir, 1), array('.', '..'))));
}

switch ($_POST["step"]) {
    case 0:
        # step 0 clear the database
        $dbh->exec("DELETE FROM Voorwerp WHERE Betalingswijze='niks'");
        $dbh->exec("DELETE FROM Gebruiker WHERE Wachtwoord='testwachtwoord'");
        $dbh->exec("ALTER TABLE Rubriek NOCHECK CONSTRAINT FK_ParentRubriek");
        $dbh->exec("DELETE FROM Rubriek");
        $dbh->exec("DELETE FROM KeyWordsLink");
        $dbh->exec("DELETE FROM KeyWords");
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
            if (strpos($file, "CREATE Users.sql") !== false) {
                # step 3 insert the new users

                # step 3.1 get the file
                $userFile = file_get_contents($file);
                #step 3.2 get random data
                $randomData = getRandomUserData();
                $voornaam = $randomData[0];
                $achternaam = $randomData[1];
                $email = $randomData[2];
                $plaatsnaam = $randomData[3];
                $refactorFile = str_replace("INSERT Users (Username,Postalcode,Location,Country,Rating) VALUES (",
                    "INSERT INTO Gebruiker (Voornaam, Achternaam, Plaatsnaam, Adresregel_1, Geboortedag, Mailbox, Wachtwoord, Latitude, Longitude, Vraag, Verkoper, Action, Bevestiging, Gebruikersnaam,Postcode,Land,Antwoordtekst) VALUES ('$voornaam', '$achternaam', '$plaatsnaam', 'Adminlaan','2000-01-01', '$email','testwachtwoord',52.718239,6.267012,1,1, 1, 1,", $userFile);
                # step 3.3 split file in inserts
                $inserts = explode("\n", $refactorFile);

                # step 3.4 loop over inserts

                foreach ($inserts as $insert) {

                    $dbh->query(substr($insert, 0, strrpos($insert, ",")) . ')');
                }
            } else {
                // setup procedures
                $voorwerpInsert = $dbh->prepare("exec voorwerpInsert ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?");
                //INSERT INTO Voorwerp (Titel, Beschrijving, Startprijs, Betalingswijze, Plaatsnaam, Land, LooptijdBeginTijdstip, Verzendkosten,Verzendinstructies, Verkoper, LooptijdEindeTijdstip, VeilingGesloten) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                $voorwerpInsert->bindParam(1, $titel);
                $voorwerpInsert->bindParam(2, $beschrijving);
                $voorwerpInsert->bindParam(3, $prijs);
                $voorwerpInsert->bindValue(4, "testBetalingswijze");
                $voorwerpInsert->bindParam(5, $locatie);
                $voorwerpInsert->bindParam(6, $land);
                $voorwerpInsert->bindValue(7, '2020-0'.rand(5,6).'-'.rand(0,1).rand(1,4).' '.rand(0,1).rand(0,9).':'.rand(0,5).''.rand(0,9).':00:000'); //'2020-05-20 12:00:00:000');
                $voorwerpInsert->bindValue(8, 5.00);
                $voorwerpInsert->bindValue(9, 'testinstructie');
                $voorwerpInsert->bindParam(10, $verkoper);
                $voorwerpInsert->bindValue(11, '2020-06-'.rand(1,2).''.rand(5,9).' '.rand(0,1).rand(0,9).':'.rand(0,5).rand(0,9).':00:000');
                $voorwerpInsert->bindValue(12, FALSE);

                $voorwerpRubriek = $dbh->prepare("exec voorwerpRubriekInsert ?, ?");
                $voorwerpRubriek->bindParam(1, $itemID);
                $voorwerpRubriek->bindParam(2, $category);

                $imageInsert = $dbh->prepare("exec fileInsert ?, ?");
                $imageInsert->bindParam(1, $imageFile);
                $imageInsert->bindParam(2, $itemID);
                $itemID = Items::get_ItemId();
                $fileText = file_get_contents($file);
                # step 4.3 Split file into items
                $splitFile = explode("INSERT Items", $fileText);
                # step 4.4 split on item parts
                array_shift($splitFile);
                foreach ($splitFile as $item) {
                    $splitParts = explode("INSERT", $item);

                    # step 4.5 insert item
                    $itemInsertParts = explode(") VALUES (", $splitParts[0]);
                    $output = preg_split("/(\'\,\'|\'\,|\,\')/", $itemInsertParts[1]);


                    $voorwerpNummer = $output[0];
                    $titel = substr($output[1], 0, 100);
                    $category = $output[2];
                    $postcode = $output[3];
                    $locatie = substr($output[4], 0, 60);
                    $land = substr($output[5], 0, 50);
                    $verkoper = $output[6];
                    $prijs = calculateCurrency($output[7], $output[8]);
                    $beschrijving = substr(removeBadElements($output[11]), 0, 4000);
                    $imageFile = $output[10];
                    $keywords = explode(" ", strtolower($titel));
                    $voorwerpInsert->execute();
                    $itemID++;
                    $voorwerpRubriek->execute();
                    //store file with new autoincrementId as id.png
                    $imageInsert->execute();

                    # step 4.6 insert images in bestanden
                    array_shift($splitParts); // remove first insert for item

                    $imageCounter = 0;
                    foreach ($splitParts as $image) {
                        # put image into database
                        if ($imageCounter < 5) {
                            $imageFile = explode('\'', $image)[1];
                            $imageInsert->execute();
                        }
                        $imageCounter++;
                    }
                }
            }
            echo "busy\n";
        }
        break;
}
echo round($_POST["step"] * 100 / (count($files) + 3));


function removeBadElements($input)
{ // remove all bad characters
    preg_replace('/(<script[^>]*>.+?<\/script>|<style[^>]*>.+?<\/style>)/s', '', $input);
    $input = strip_tags($input, '<p><a><h1><h2><h3><h4><h5><br><b><i>');
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

function getRandomUserData()
{
    $firstnames = ["Piet", "Jan", "Winter", "Zwaluw", "Maan", "Ster", "Zomer"];
    $surname = ["cohen", "frank", "Polak", "de Vries", "de Jong", "de Leeuw"];
    $emails = ["test@hotmail.com", "hallo@gmail.com", "xtc@yahoo.com"];
    $city = ['Ruinerwold', 'Barnevelt', 'Gent', 'Hatert'];
    return [$firstnames[array_rand($firstnames)], $surname[array_rand($surname)], $emails[array_rand($emails)], $city[array_rand($city)]];
}

?>
