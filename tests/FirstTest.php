<?php

class FirstTest extends PHPUnit\Framework\TestCase
{
    protected $testDatabase;
    function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->startAutoLoader();
        $this->setupGlobals();
        $this->setupDatabase();
        //$testDatabase = Database::connectToDatabase();
    }

    function setupGlobals(){
        Secrets::getSecrets();
        $GLOBALS['dbh'] = Database::connectToDatabase();
    }

    function setupDatabase(){
        echo "setting up the database tables";
    }
    function testQuestions(){
        $this->assertTrue(true);
    }
    function testUserInsertion()
    {
        // insert a user
        User::insertUser(array(":Gebruikersnaam"=>"test",":Voornaam"=>"Freek",":Achternaam"=>"van de Ven",":Adresregel_1"=>"test",
        ":Adresregel_2"=>""  ,":Postcode"=>"6671GK",":Plaatsnaam"=>"Zetten",":Land"=>"Nederland",":Geboortedag"=>"2020-04-11",
        ":Mailbox"=>"test@hotmail.com",":Wachtwoord"=>"testwachtwoord",":Vraag"=>User::getQuestions()[0]['Vraagnummer'],":Antwoordtekst"=>"test",":Verkoper"=>FALSE,":Action"=>FALSE, ":Bevestiging"=>TRUE));
        $this->assertFalse(empty(User::getUser("test")));
    }

    function testRegistration(){
        $this->assertTrue(true);
    }

    function testDeleteUser(){
        // delete user
        $this->assertTrue(empty(User::getUser("test")));
    }

    function startAutoLoader(){
        #this function loads all classes in classes/models/ whenever they are called in our program.
        spl_autoload_register(function ($class_name) {
            include '../classes/models/' . $class_name . '.php';
        });
    }
}