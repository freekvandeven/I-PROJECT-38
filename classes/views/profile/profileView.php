<?php
$profile_data = User::getUser($_SESSION['name']);

// MAAKT HET VISEUELE GEDEELTE VAN EEN BOOLEAN:
$verkoper = ($profile_data['Verkoper']) ? 'Ja' : 'Nee';

?>

<main>
    <div class="container">
        <div class="mijnEenmaalAndermaalTitel">
            <h2 class="text-center">Mijn EenmaalAndermaal</h2>
        </div>

        <div class="container">
            <h2>Mijn gegevens</h2>
            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Persoonsgegevens</h4>
                            <img src="images/profilePicture.png" class="card-img" alt="profielfoto">
                            <p>Uw profielfoto is zichtbaar voor iedereen.</p>
                            <p><b>Emailadres: </b><?=$profile_data['Mailbox']?></p>
                            <p><b>Voornaam: </b><?=$profile_data['Voornaam']?></p>
                            <p><b>Achternaam: </b><?=$profile_data['Achternaam']?></p>
                            <p><b>Geboortedatum: </b><?=$profile_data['Geboortedag']?></p>
                            <p><b>Land: </b><?=$profile_data['Land']?></p>
                            <p><b>Adres 1: </b><?=$profile_data['Adresregel_1']?></p>
                            <p><b>Adres 2: </b><?=$profile_data['Adresregel_2']?></p>
                            <p><b>Postcode: </b><?=$profile_data['Postcode']?></p>
                            <p><b>Plaatsnaam: </b><?=$profile_data['Plaatsnaam']?></p>
                            <a href="profile.php?action=update" class="btn btn-primary">Wijzig</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Inloggegevens</h4>
                            <p><b>Gebruikersnaam: </b><?=$profile_data['Gebruikersnaam']?></p>
                            <p><b>Wachtwoord: </b>*****</p>
                            <a href="profile.php?action=update" class="btn btn-primary">Wijzig</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Beveiliging</h4>
                            <p><b>Vraag: </b><?php echo User::getQuestion($profile_data['Vraag']);?></p>
                            <p><b>Antwoord: </b><?=$profile_data['Antwoordtekst']?></p>
                            <a href="profile.php?action=update" class="btn btn-primary">Wijzig</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Verkoper</h4>
                            <p><b>Verkoper: </b><?=$verkoper?></p>
                            <?php if(!$profile_data['Verkoper']) : ?>
                            <a href="profile.php?action=upgrade" class="btn btn-primary">Wijzig</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div> <!-- Eind vd "ROW" -->
            <h2>Mijn veilingen</h2>
            <div class="row">
                <?php
                if($profile_data['Verkoper']) : ?>
                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Mijn veilingen</h4>
                            <p>Om uw aangeboden veilingen te bekijken, klikt u hieronder op de knop.</p>
                            <a href="profile.php?action=item" class="btn btn-primary">Bekijk mijn veilingen</a>
                        </div>
                    </div>
                </div><?php endif; ?>
                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Favoriete veilingen</h4>
                            <p>Wanneer u op een veiling biedt, wordt deze toegevoegd aan uw favorieten. Om deze te bekijken, klikt u hieronder.</p>
                            <a href="profile.php?action=favorite" class="btn btn-primary">Favoriete veilingen</a>
                        </div>
                    </div>
                </div>
                <?php
                if($profile_data['Verkoper']) : ?>
                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Product aanbieden</h4>
                            <p>Als u een verkoper bent, kunt u tweedehands product aanbieden op EenmaalAndermaal. </p>
                            <a href="addProduct.php" class="btn btn-primary">Product aanbieden</a>
                        </div>
                    </div>
                </div><?php endif; ?>
            </div>
        </div>
    </div>
</main>
    

