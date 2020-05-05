<?php

class Database{

    static function testMethod(){
        echo "Testing classes";
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