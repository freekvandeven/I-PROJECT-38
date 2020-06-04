<?php
$profile_data = User::getUser($_SESSION['name']);
$showButton = false;
?>

<main class="updateGegevensPagina">
    <div class="container col-xl-12">
        <form class="updateForm" action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="token" value="<?=$token?>">
            <input type="hidden" name="option" value="<?=$_GET['option']?>">
            <?php
            if(isset($_GET['option'])) {
                // PERSOONSGEGEVENS
                if ($_GET["option"] == 'persoonsgegevens') {
                $showButton=true; ?>
                <h2 class="text-center">Persoonsgegevens wijzigen</h2>
                <p class="text-center">Pas uw gegevens zodanig toe aan uw wensen.</p>
                <?php if (isset($err)) { ?>
                <div class="errorMessage">
                    <span><?=$err?></span>
                </div>
                <?php } ?>
                <div class="container">
                    <h5>Persoonsgegevens</h5>
                    <div class="form-row">
                        <!-- EMAILADRES -->
                        <div class="form-group col-md-4">
                            <label for="email">Emailadres</label>
                            <input type="email" class="form-control" name="email" id="email"
                                   placeholder="Uw nieuwe emailadres" value="<?= $profile_data['Mailbox'] ?>">
                        </div>
                        <!-- TELEFOONNUMMER 1 -->
                        <?php $profile_phone_nr = User::getPhoneNumber($_SESSION['name']); ?>
                        <div class="form-group col-md-4">
                            <label for="telnr1">Telefoonnummer</label>
                            <input type="tel" class="form-control" name="phone-number" id="telnr1"
                                   placeholder="Uw telefoonnummer" value="<?=$profile_phone_nr?>">
                        </div>
                        <!-- TELEFOONNUMMER 2 -->
                        <div class="form-group col-md-4">
                            <label for="telnr2">Tweede telefoonnummer</label>
                            <input type="tel" class="form-control" name="phone-number2" id="telnr2"
                                   placeholder="Uw tweede telefoonnummer">
                        </div>
                    </div>

                    <h5>Locatie</h5>
                    <div class="form-row">
                        <!-- ADRES 1 -->
                        <div class="form-group col-md-6">
                            <label for="adres1">Adres</label>
                            <input type="text" class="form-control" name="adress" id="adres1"
                                   value="<?=$profile_data['Adresregel_1']?>" placeholder="Uw adres">
                        </div>
                        <!-- ADRES 2 -->
                        <div class="form-group col-md-6">
                            <label for="adres2">Adres 2</label>
                            <input type="text" class="form-control" name="adress2" id="adres2"
                                   value="<?=$profile_data['Adresregel_2']?>" placeholder="Uw tweede adres">
                        </div>
                        <!-- LAND -->
                        <div class="form-group col-md-5">
                            <label for="land">Land</label>
                            <input type="text" class="form-control" name="country" id="land"
                                   placeholder="Land" value="<?=$profile_data['Land']?>">
                        </div>
                        <!-- PLAATS -->
                        <div class="form-group col-md-5">
                            <label for="plaats">Plaats</label>
                            <input type="text" class="form-control" name="place" id="plaats"
                                   placeholder="Woonplaats" value="<?=$profile_data['Plaatsnaam']?>">
                        </div>
                        <!-- POSTCODE -->
                        <div class="form-group col-md-2">
                            <label for="postcode">Postcode</label>
                            <input type="text" class="form-control" name="postcode" id="postcode"
                                   placeholder="Postcode" value="<?=$profile_data['Postcode']?>">
                        </div>
                    </div>
                </div>
                <?php }

                // INLOGGEGEVENS
                if ($_GET["option"] == 'inloggegevens') {
                $showButton=true; ?>
                <h2 class="text-center">Inloggegevens wijzigen</h2>
                <p class="text-center">Pas uw gegevens zodanig toe aan uw wensen.</p>
                <?php if (isset($err)) { ?>
                    <div class="errorMessage">
                        <span><?=$err?></span>
                    </div>
                <?php } ?>
                <div class="container">
                    <h5>Inloggegevens</h5>
                    <div class="form-row">
                        <!-- GEBRUIKERSNAAM -->
                        <div class="form-group col-md-4">
                            <label for="gebruikersnaam">Gebruikersnaam (niet aan te passen)</label>
                            <input type="text" class="readonly form-control" name="username" id="gebruikersnaam"
                                   value="<?= $profile_data['Gebruikersnaam'] ?>" readonly>
                        </div>
                    </div>

                    <div class="form-row">
                        <!-- WACHTWOORD 1 -->
                        <div class="form-group col-md-4">
                            <label for="password1">Nieuw Wachtwoord</label>
                            <input type="password" class="form-control" name="password" id="password1"
                                   placeholder="Uw nieuwe wachtwoord">
                        </div>
                        <!-- WACHTWOORD 2 -->
                        <div class="form-group col-md-4">
                            <label for="password2">Herhaal wachtwoord</label>
                            <input type="password" class="form-control" name="confirmation" id="password2"
                                   placeholder="Herhaal wachtwoord">
                        </div>
                    </div>
                </div>
                <?php }

                // BEVEILIGINGSGEGEVENS UPDATEN
                if ($_GET["option"] == 'beveiligingsgegevens') {
                $showButton=true; ?>
                <h2 class="text-center">Beveiligingsgegevens wijzigen</h2>
                <p class="text-center">Pas uw gegevens zodanig toe aan uw wensen.</p>
                <?php if (isset($err)) { ?>
                    <div class="errorMessage">
                        <span><?=$err?></span>
                    </div>
                <?php } ?>
                <div class="container">
                    <h5>Inloggegevens</h5>
                    <div class="form-row">
                        <!-- GEHEIME VRAAG -->
                        <div class="form-group col-md-6">
                            <label for="geheimeVraag">Geheime vraag</label>
                            <select class="custom-select" name="question" id="geheimeVraag">
                                <?php
                                $selected = User::getUser($_SESSION['name'])['Vraag'];
                                foreach (User::getQuestions() as $question) {
                                    if ($question['Vraagnummer'] == $selected) {
                                        echo "<option selected ";
                                    } else {
                                        echo "<option ";
                                    }
                                    echo "value='" . $question['Vraagnummer'] . "'>" . $question['TekstVraag'] . "</option>";
                                } ?>
                            </select>
                        </div>
                        <!-- ANTWOORD GEHEIME VRAAG -->
                        <div class="form-group col-md-6">
                            <label for="antwGeheimeVraag">Antwoord</label>
                            <input type="text" class="form-control" name="answer" id="antwGeheimeVraag"
                                   placeholder="Antwoord" value="<?= $profile_data['Antwoordtekst'] ?>">
                        </div>
                    </div>
                </div>
                <?php }

                // PROFIELFOTO UPDATEN
                if ($_GET["option"] == 'profielfoto') {
                $showButton=true;?>
                <h2 class="text-center">Profielfoto wijzigen</h2>
                <p class="text-center">Pas uw gegevens zodanig toe aan uw wensen.</p>
                <?php if (isset($err)) { ?>
                    <div class="errorMessage">
                        <span><?=$err?></span>
                    </div>
                <?php } ?>
                <div class="container">
                    <h5>Profielfoto</h5>
                    <div class="form-row">
                        <!-- PROFIELFOTO UPLOADEN -->
                        <div class="form-group col-md-6">
                            <label for="img">Profielfoto</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="img" name="img" accept="image/*">
                                <label class="custom-file-label" for="img" data-browse="Bestand kiezen">Pas uw profielfoto aan</label>
                            </div>
                        </div>
                    </div>

                    <?php require_once('image-crop.php'); ?>

                    <h5>Aanpassen huidige profielfoto</h5>

                    <!-- Huidige profielfoto -->
                    <h1>Crop Image</h1>
                    <img src="<?=getProfileImage($_SESSION['name'])?>" id="cropbox" class="img" /><br/>
                    <input type='button' id="crop" value='CROP'><br>

                    <!-- Cropped Image -->
                    <img src="#" id="cropped_img" style="display: none;">

                </div>

                <script type="text/javascript">
                    $(document).ready(function(){
                        var size;
                        $('#cropbox').Jcrop({
                            aspectRatio: 1,
                            onSelect: function(c){
                                size = {x:c.x,y:c.y,w:c.w,h:c.h};
                                $("#crop").css("visibility", "visible");
                            }
                        });

                        $("#crop").click(function(){
                            var img = $("#cropbox").attr('src');
                            $("#cropped_img").show();
                            $("#cropped_img").attr('src','image-crop.php?x='+size.x+'&y='+size.y+'&w='+size.w+'&h='+size.h+'&img='+img);
                        });
                    });
                </script>

                <?php }

                // VERKOPERSGEGEVENS
                if ($_GET["option"] == 'verkopersgegevens') {
                    if($profile_data['Verkoper']){
                        $showButton=true;
                        $userSellerInformation = Seller::getSeller($_SESSION['name']);?>
                        <h2 class="text-center">Verkopersgegevens wijzigen</h2>
                        <p class="text-center">Pas uw gegevens zodanig toe aan uw wensen.</p>
                        <?php if (isset($err)) { ?>
                            <div class="errorMessage">
                                <span><?=$err?></span>
                            </div>
                        <?php } ?>
                        <div class="container">
                            <h5>Verkopersgegevens</h5>
                            <div class="form-row">
                                <!-- BANK -->
                                <div class="form-group col-md-6">
                                    <label for="bank">Bank</label>
                                    <input type="text" class="form-control" name="bank" id="bank" placeholder="Uw bank" value="<?=$userSellerInformation['Bank']?>">
                                </div>
                                <!-- BANKREKENING -->
                                <div class="form-group col-md-6">
                                    <label for="bankrekening">Bankrekening</label>
                                    <input type="text" class="form-control" name="bankrekening" id="bankrekening" placeholder="Uw bankrekening" value="<?=$userSellerInformation['Bankrekening']?>">
                                </div>
                                <!-- CONTROLEOPTIE -->
                                <div class="form-group col-md-6">
                                    <label for="controlenummer">ControleOptie</label>
                                    <input type="text" class="form-control" name="controlenummer" id="controlenummer" placeholder="Uw controlenummer" value="<?=$userSellerInformation['ControleOptie']?>v">
                                </div>
                                <!-- CREDITCARD -->
                                <div class="form-group col-md-6">
                                    <label for="creditcard">Creditcard</label>
                                    <input type="text" class="form-control" name="creditcard" id="creditcard" placeholder="Uw creditcard" value="<?=$userSellerInformation['Creditcard']?>">
                                </div>
                            </div>
                        </div>
                    <?php
                    } else {
                        $toast = 'Actie geweigerd!';
                    }
                }
            }

            else {
                $showButton=true;?>
                <h2 class="text-center">Huidige gegevens</h2>
                <p class="text-center">Pas uw gegevens zodanig toe aan uw wensen.</p>
                <?php if (isset($err)) { ?>
                    <div class="errorMessage">
                        <span><?=$err?></span>
                    </div>
                <?php } ?>
                <!-- ACCOUNTGEGEVENS-->
                <div class="container">
                    <h5>Accountgegevens en beveiliging</h5>
                    <div class="form-row">
                        <!-- GEBRUIKERSNAAM -->
                        <div class="form-group col-md-4">
                            <label for="gebruikersnaam">Gebruikersnaam (niet aan te passen)</label>
                            <input type="text" class="readonly form-control" name="username" id="gebruikersnaam"
                                   value="<?= $profile_data['Gebruikersnaam'] ?>" readonly>
                        </div>
                        <!-- WACHTWOORD 1 -->
                        <div class="form-group col-md-4">
                            <label for="password1">Nieuw Wachtwoord</label>
                            <input type="password" class="form-control" name="password" id="password1" placeholder="Uw nieuwe wachtwoord">
                        </div>
                        <!-- WACHTWOORD 2 -->
                        <div class="form-group col-md-4">
                            <label for="password2">Herhaal wachtwoord</label>
                            <input type="password" class="form-control" name="confirmation" id="password2" placeholder="Herhaal nieuw wachtwoord">
                        </div>
                        <!-- GEHEIME VRAAG -->
                        <div class="form-group col-md-4">
                            <label for="geheimeVraag">Geheime vraag</label>
                            <select class="custom-select" name="question" id="geheimeVraag">
                                <?php
                                $selected = User::getUser($_SESSION['name'])['Vraag'];
                                foreach(User::getQuestions() as $question){
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
                            <input type="text" class="form-control" name="answer" id="antwGeheimeVraag"
                                   placeholder="Antwoord" value="<?=$profile_data['Antwoordtekst']?>">
                        </div>

                        <!-- PROFIELFOTO UPLOADEN -->
                        <div class="form-group col-md-4">
                            <label for="img">Profielfoto</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="img" name="img" accept="image/*">
                                <label class="custom-file-label" for="img" data-browse="Bestand kiezen">Pas uw profielfoto aan</label>
                            </div>
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
                            <input type="email" class="form-control" name="email" id="email"
                                   placeholder="Uw nieuwe emailadres" value="<?=$profile_data['Mailbox']?>">
                        </div>
                        <!-- TELEFOONNUMMER 1 -->
                        <div class="form-group col-md-4">
                            <label for="telnr1">Telefoonnummer</label>
                            <input type="tel" class="form-control" name="phone-number" id="telnr1"
                                   placeholder="Uw telefoonnummer" value="<?=$profile_phone_nr?>">
                        </div>
                        <!-- TELEFOONNUMMER 2 -->
                        <div class="form-group col-md-4">
                            <label for="telnr2">Tweede telefoonnummer</label>
                            <input type="tel" class="form-control" name="phone-number2" id="telnr2"
                                   placeholder="Uw tweede telefoonnummer">
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
                            <input type="text" class="form-control" name="country" id="land"
                                   placeholder="Land" value="<?=$profile_data['Land']?>">
                        </div>
                        <!-- PLAATS -->
                        <div class="form-group col-md-5">
                            <label for="plaats">Plaats</label>
                            <input type="text" class="form-control" name="place" id="plaats"
                                   placeholder="Plaats" value="<?=$profile_data['Plaatsnaam']?>">
                        </div>
                        <!-- POSTCODE -->
                        <div class="form-group col-md-2">
                            <label for="postcode">Postcode</label>
                            <input type="text" class="form-control" name="postcode" id="postcode"
                                   placeholder="Postcode" value="<?=$profile_data['Postcode']?>">
                        </div>
                    </div>
                </div> <?php }

            if($showButton): ?>
                <!-- GA-TERUG-KNOP -->
                <div class="gaTerugKnopBox text-center">
                    <a href="profile.php">Ga terug</a>
                </div>
                <!-- SUBMIT-KNOP -->
                <div class="text-center">
                    <button class="updateButton" type="submit" name="action" value="update">Update Informatie</button>
                </div>
            <?php endif; ?>
        </form>
    </div>

    <script>
        $(".custom-file-input").on("change", function () {
            var thumbnail = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(thumbnail);
        });
    </script>
</main>
