<?php
$profile_data = getUser($_SESSION['name']);
?>

<main>
    <div id="login-box" class="col-md-12">
        <form id="login-form" class="updateForm" action="" method="post">
            <h2 class="text-center">Huidige gegevens</h2>
            <?php if(isset($err))echo $err;?>
            <p class="text-center">Pas uw gegevens zodanig toe aan uw wensen.</p>
            <!-- ACCOUNTGEGEVENS-->
            <div class="container">
                <h5>Accountgegevens en beveiliging</h5>
                <div class="form-row">
                    <!-- GEBRUIKERSNAAM -->
                    <div class="form-group col-md-4">
                        <label for="gebruikersnaam">Gebruikersnaam</label>
                        <input type="text" class="form-control" name="username" id="gebruikersnaam" value="<?=$profile_data['Gebruikersnaam']?>">
                    </div>
                    <!-- WACHTWOORD 1 -->
                    <div class="form-group col-md-4">
                        <label for="password1">Nieuw Wachtwoord</label>
                        <input type="password" class="form-control" name="password" id="password1" placeholder="wachtwoord">
                    </div>
                    <!-- WACHTWOORD 2 -->
                    <div class="form-group col-md-4">
                        <label for="password2">Herhaal wachtwoord</label>
                        <input type="password" class="form-control" name="confirmation" id="password2" placeholder="wachtwoord">
                    </div>
                    <!-- GEHEIME VRAAG -->
                    <div class="form-group col-md-4">
                        <label for="geheimeVraag">Geheime vraag</label>
                        <select class="custom-select" name="secret-question" id="geheimeVraag">
                            <?php
                            $selected = getUser($_SESSION['name'])['Vraag'];
                            foreach(getQuestions() as $question){
                                if($question['Vraagnummer']== $selected){
                                    echo "<option selected ";
                                } else {
                                    echo "<option ";
                                }
                                echo "value='".$question['Vraagnummer']."'>".$question['TekstVraag']."</option>";
                            } ?>
                        </select>
                    </div>
                    <!-- ANTWOORD GEHEIME VRAAG -->
                    <div class="form-group col-md-4">
                        <label for="antwGeheimeVraag">Antwoord</label>
                        <input type="text" class="form-control" name="secret-answer" id="antwGeheimeVraag" value="<?=$profile_data['Antwoordtekst']?>">
                    </div>
                </div>
            </div>
            <!-- PERSOONLIJKE GEGEVENS-->
            <div class="container">
                <h5>Persoonlijke gegevens</h5>
                <div class="form-row">
                    <!-- EMAILADRES -->
                    <div class="form-group col-md-4">
                        <label for="email">Emailadres</label>
                        <input type="email" class="form-control" name="email" id="email" value="<?=$profile_data['Mailbox']?>">
                    </div>
                    <!-- TELEFOONNUMMER 1 -->
                    <div class="form-group col-md-4">
                        <label for="telnr1">Telefoonnummer</label>
                        <input type="tel" class="form-control" name="phone-number" id="telnr1" placeholder="Uw telefoonnummer">
                    </div>
                    <!-- TELEFOONNUMMER 2 -->
                    <div class="form-group col-md-4">
                        <label for="telnr2">Tweede telefoonnummer</label>
                        <input type="tel" class="form-control" name="phone-number" id="telnr2" placeholder="Uw tweede telefoonnummer">
                    </div>
                    <!-- ADRES 1 -->
                    <div class="form-group col-md-6">
                        <label for="adres1">Adres</label>
                        <input type="text" class="form-control" name="adress" id="adres1" value="<?=$profile_data['Adresregel_1']?>" placeholder="Uw adres">
                    </div>
                    <!-- ADRES 2 -->
                    <div class="form-group col-md-6">
                        <label for="adres2">Adres 2</label>
                        <input type="text" class="form-control" name="adress2" id="adres2" value="<?=$profile_data['Adresregel_2']?>" placeholder="Uw tweede adres">
                    </div>
                    <!-- LAND -->
                    <div class="form-group col-md-5">
                        <label for="land">Land</label>
                        <input type="text" class="form-control" name="country" id="land" value="<?=$profile_data['Land']?>">
                    </div>
                    <!-- PLAATS -->
                    <div class="form-group col-md-5">
                        <label for="plaats">Plaats</label>
                        <input type="text" class="form-control" name="place" id="plaats" value="<?=$profile_data['Plaatsnaam']?>">
                    </div>
                    <!-- POSTCODE -->
                    <div class="form-group col-md-2">
                        <label for="postcode">Postcode</label>
                        <input type="text" class="form-control" name="postcode" id="postcode" value="<?=$profile_data['Postcode']?>">
                    </div>
                </div>
            </div>
            <!-- GA-TERUG-KNOP -->
            <div class="form-group text-center">
                <a href="profile.php">Ga terug</a><br>
            </div>
            <!-- SUBMIT-KNOP -->
            <div class="form-group text-center">
                <button class="updateButton" type="submit" name="submit" value="update">Update Informatie</button>
            </div>
        </form>
    </div>
</main>
