 <?php

class Database{
    public $dbh;
    function __construct()
    {
        $this->dbh = self::connectToDatabase();
    }

    static function connectToDatabase()
    {
        global $host;
        global $dbname;
        global $username;
        global $password;
        global $options;
        global $serverType;
        try {
            $dbh = new PDO("$serverType:$host;$dbname", $username, $password, $options);
            return $dbh;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    static function rateSeller($seller,$giver, $rating)
    {
        global $dbh;
        $data = $dbh->prepare('INSERT INTO Beoordeling (Gebruikersnaam, GegevenDoor, Rating) VALUES (:verkoper, :gever, :rating)');
        $data->execute([":verkoper" => $seller,"gever"=>$giver,":rating" => $rating]);
    }

    static function getAvgRating($username)
    {
        global $dbh;
        $data = $dbh->prepare('SELECT AVG(cast(Rating as Float)) FROM Beoordeling WHERE Gebruikersnaam = :Gebruikersnaam');
        $data->execute([":Gebruikersnaam" => $username]);
        $result = $data->fetchAll(PDO::FETCH_ASSOC);
        return $result[0];
    }

    static function getAmountRatings($username) {
        global $dbh;
        $data = $dbh->prepare('SELECT COUNT(BeoordelingsNr) FROM Beoordeling WHERE Gebruikersnaam = :Gebruikersnaam');
        $data->execute([":Gebruikersnaam" => $username]);
        $result = $data->fetchAll(PDO::FETCH_ASSOC);
        return $result[0];// untested function
    }

    static function getFeedback ($firstname, $surname, $phoneNumber, $message) {
        $fb  =  'Hallo ' . $firstname . '! <br>';
        $fb .= "Hartstikke bedankt voor insturen van uw formulier! <br>";
        $fb .= "U heeft de volgende gegevens achtergelaten: <br> ";

        $fb .= 'Voornaam: ' . $firstname . '<br>';
        $fb .= 'Achternaam: ' . $surname . '<br>';
        $fb .= 'Telefoonnummer: ' . $phoneNumber . '<br>';
        $fb .= 'Bericht: ' . $message . '<br>';

        echo $fb;
    }

}