<?php
$profile_data = User::getUser($_SESSION['name']);

// MAAKT HET VISEUELE GEDEELTE VAN EEN BOOLEAN:
$verkoper = ($profile_data['Verkoper']) ? 'Ja' : 'Nee';
$bootstrapGrid1 = "col-xl-3 col-md-6 col-sm-6 col-6";
$bootstrapGrid2 = "col-xl-4 col-lg-4 col-md-6 col-sm-6 col-6";
?>

<main class="profielPagina">
    <div class="jumbotron">
        <h2 class="display-5">Uw EenmaalAndermaal</h2>
        <p>Op deze pagina kunt u uw gegevens inzien, wijzigen of verwijderen. Ook kunt u al uw activiteiten bijhouden
            m.b.t. veilingen.</p>
    </div>

    <div class="container">
        <div class="container">
            <h2 class="titel col-xl-3 col-md-6 col-sm-6">Mijn gegevens</h2>
            <div class="verkopersPaginaButtonBox text-right">
                <a href="profile.php?id=<?= $profile_data['Gebruikersnaam'] ?>" class="verkopersPaginaButton"
                   role="button">Bekijk uw verkoperspagina</a>
            </div>

            <div class="row">
                <div class="<?=$bootstrapGrid1?>">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="subTitel card-title">Persoonsgegevens</h4>
                            <div class="itemImageProfilePage">
                                <a href="profile.php?action=update&option=profielfoto">
                                    <img src="<?=getProfileImage($_SESSION['name'])?>" class="profielfoto card-img" alt="profielfoto">
                                </a>
                            </div>
                            <p class="wijzigFotoLinkp">
                                <a href="profile.php?action=update&option=profielfoto" class="wijzigFotoLink">
                                    Wijzig profielfoto <img src="images/edit.png" alt="Wijzig">
                                </a>
                            </p>
                            <p>Uw profielfoto is zichtbaar voor iedereen.</p>
                            <p><b>Emailadres: </b><?= $profile_data['Mailbox'] ?></p>
                            <p><b>Voornaam: </b><?= $profile_data['Voornaam'] ?></p>
                            <p><b>Achternaam: </b><?= $profile_data['Achternaam'] ?></p>
                            <a href="profile.php?action=update&option=persoonsgegevens"
                               class="btn btn-primary">Wijzig</a>
                        </div>
                    </div>
                </div>
                <div class="<?= $bootstrapGrid1 ?>">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="subTitel card-title">Inloggegevens</h4>
                            <p><b>Gebruikersnaam: </b><?= $profile_data['Gebruikersnaam'] ?></p>
                            <p><b>Wachtwoord: </b>*****</p>
                            <a href="profile.php?action=update&option=inloggegevens" class="btn btn-primary">Wijzig</a>
                        </div>
                    </div>
                </div>
                <div class="<?= $bootstrapGrid1 ?>">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="subTitel card-title">Beveiliging</h4>
                            <p><b>Vraag: </b><?php echo User::getQuestion($profile_data['Vraag']); ?></p>
                            <p><b>Antwoord: </b><?= $profile_data['Antwoordtekst'] ?></p>
                            <a href="profile.php?action=update&option=beveiligingsgegevens"
                               class="btn btn-primary">Wijzig</a>
                        </div>
                    </div>
                </div>
                <div class="<?= $bootstrapGrid1 ?>">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="subTitel card-title">Verkoper</h4>
                            <?php if (!$profile_data['Verkoper']) : ?>
                                <p><b>Verkoper: </b><?= $verkoper ?></p>
                                <a href="profile.php?action=upgrade" class="btn btn-primary">Word verkoper</a>
                            <?php endif;
                            if($profile_data['Verkoper']) :
                                $userSellerInformation = Seller::getSeller($_SESSION['name']) ?>
                                <p><b>Bank: </b><?=$userSellerInformation['Bank']?></p>
                                <p><b>Bankrekening: </b><?=$userSellerInformation['Bankrekening']?></p>
                                <p><b>Creditcard: </b><?=$userSellerInformation['Creditcard']?></p>
                                <a href="profile.php?action=update&option=verkopersgegevens" class="btn btn-primary">Wijzig</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div> <!-- Eind vd "ROW" -->

            <h2 class="tussenLijn">Veilingen</h2>
            <div class="row">
                <?php
                if ($profile_data['Verkoper']) : ?>
                <div class="<?= $bootstrapGrid2 ?>">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="subTitel card-title">Mijn veilingen</h4>
                            <p>Om uw aangeboden veilingen te bekijken, klikt u hieronder op de knop.</p>
                            <a href="profile.php?action=item" class="btn btn-primary">Bekijk mijn veilingen</a>
                        </div>
                    </div>
                </div><?php endif; ?>
                <div class="<?= $bootstrapGrid2 ?>">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="subTitel card-title">Favoriete veilingen</h4>
                            <p>Wanneer u op een veiling biedt, wordt deze toegevoegd aan uw favorieten.</p>
                            <a href="profile.php?action=favorite" class="btn btn-primary">Favoriete veilingen</a>
                        </div>
                    </div>
                </div>
                <?php
                if ($profile_data['Verkoper']) : ?>
                <div class="<?= $bootstrapGrid2 ?>">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="subTitel card-title">Product aanbieden</h4>
                            <p>Als u een verkoper bent, kunt u tweedehands product aanbieden op EenmaalAndermaal. </p>
                            <a href="addProduct.php" class="btn btn-primary">Product aanbieden</a>
                        </div>
                    </div>
                </div><?php endif; ?>
            </div>

            <h2 class="tussenLijn">Mijn account</h2>
            <div class="row">
                <div class="<?= $bootstrapGrid2 ?>">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Notificaties Bekijken</h4>
                            <p>Hier kunt u notificaties zien en chatten met andere gebruikers. </p>
                            <a href="profile.php?action=notifications" class="btn btn-primary">Notificaties</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6 col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Instellingen</h4>
                            <p>Hier kunt u uw account instellingen veranderen.  </p>
                            <a href="profile.php?action=settings" class="btn btn-primary">Instellingen</a>
                        </div>
                    </div>
                </div>
                <div class="<?= $bootstrapGrid2 ?>">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Account verwijderen</h4>
                            <p>Als u uw account wilt verwijderen kan dat. Dit verwijdert ook alle geschiedenis waar u in
                                voorkomt. </p>
                            <form action="" method="post"
                                  onsubmit="return confirm('Weet je zeker dat je jouw account wilt deleten? Je kan hierna niet meer terug.');">
                                <input type="hidden" name="token" value="<?= $token ?>">
                                <button class="deleteAccountButton btn-primary" type="submit" name="action" value="delete">Verwijder account</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
    

