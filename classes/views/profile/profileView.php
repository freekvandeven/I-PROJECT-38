<?php
$profile_data = User::getUser($_SESSION['name']);

// MAAKT HET VISEUELE GEDEELTE VAN EEN BOOLEAN:
$verkoper = ($profile_data['Verkoper']) ? 'Ja' : 'Nee';

?>

<script src="https://cdn.jsdelivr.net/npm/darkmode-js@1.5.5/lib/darkmode-js.min.js"></script>
<script src="includes/darkMode.js"></script>

<main class="profielPagina">
    <div class="jumbotron">
        <h2 class="display-5">Uw EenmaalAndermaal</h2>
        <p>Op deze pagina kunt u uw gegevens inzien, wijzigen of verwijderen. Ook kunt u al uw activiteiten bijhouden m.b.t. veilingen.</p>
    </div>

    <div class="container">

        <div class="container">

            <h2 class="titel col-xl-3 col-md-6 col-sm-6">Mijn gegevens</h2>
            <div class="verkopersPaginaButtonBox text-right">
                <a href="profile.php?id=<?=$profile_data['Gebruikersnaam']?>" class="verkopersPaginaButton" role="button">Bekijk uw verkoperspagina</a>
            </div>

            <div class="row">
                <div class="col-xl-3 col-md-6 col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="subTitel card-title">Persoonsgegevens</h4>
                            <?php if(file_exists("upload/users/".$_SESSION['name'].".png")):?>
                            <div class="itemImageProfilePage">
                                <img src="upload/users/<?=$_SESSION['name']?>.png" class="card-img" alt="profielfoto">
                            </div>
                            <?php else :?>
                            <img src="images/profilePicture.png" class="card-img" alt="profielfoto">
                            <?php endif;?>
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
                <div class="col-xl-3 col-md-6 col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="subTitel card-title">Inloggegevens</h4>
                            <p><b>Gebruikersnaam: </b><?=$profile_data['Gebruikersnaam']?></p>
                            <p><b>Wachtwoord: </b>*****</p>
                            <a href="profile.php?action=update" class="btn btn-primary">Wijzig</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="subTitel card-title">Beveiliging</h4>
                            <p><b>Vraag: </b><?php echo User::getQuestion($profile_data['Vraag']);?></p>
                            <p><b>Antwoord: </b><?=$profile_data['Antwoordtekst']?></p>
                            <a href="profile.php?action=update" class="btn btn-primary">Wijzig</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="subTitel card-title">Verkoper</h4>
                            <p><b>Verkoper: </b><?=$verkoper?></p>
                            <?php if(!$profile_data['Verkoper']) : ?>
                            <a href="profile.php?action=upgrade" class="btn btn-primary">Wijzig</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div> <!-- Eind vd "ROW" -->
            <h2 class="tussenLijn">Mijn veilingen</h2>
            <div class="row">
                <?php
                if($profile_data['Verkoper']) : ?>
                <div class="col-xl-4 col-md-6 col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="subTitel card-title">Mijn veilingen</h4>
                            <p>Om uw aangeboden veilingen te bekijken, klikt u hieronder op de knop.</p>
                            <a href="profile.php?action=item" class="btn btn-primary">Bekijk mijn veilingen</a>
                        </div>
                    </div>
                </div><?php endif; ?>
                <div class="col-xl-4 col-md-6 col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="subTitel card-title">Favoriete veilingen</h4>
                            <p>Wanneer u op een veiling biedt, wordt deze toegevoegd aan uw favorieten.</p>
                            <a href="profile.php?action=favorite" class="btn btn-primary">Favoriete veilingen</a>
                        </div>
                    </div>
                </div>
                <?php
                if($profile_data['Verkoper']) : ?>
                <div class="col-xl-4 col-md-6 col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="subTitel card-title">Product aanbieden</h4>
                            <p>Als u een verkoper bent, kunt u tweedehands product aanbieden op EenmaalAndermaal. </p>
                            <a href="addProduct.php" class="btn btn-primary">Product aanbieden</a>
                        </div>
                    </div>
                </div><?php endif; ?>
                <div> <!--temp-->
                    <form action="" method="post" onsubmit="return confirm('Weet je zeker dat je jouw account wilt deleten? Je kan hierna niet meer terug.');">
                        <input type="hidden" name="token" value="<?=$token?>">
                        <button class="registerButton" type="submit" name="action" value="delete">Delete account</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
    

