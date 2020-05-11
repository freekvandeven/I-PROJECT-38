<?php
$profile_data = User::getUser($_SESSION['name']);
$profile_data_inspect_user = User::getUser($_GET['id']);

if(empty($profile_data_inspect_user)){
    header("location: profile.php");
}

$boughtItems = Items::getBuyerItems($profile_data_inspect_user['Gebruikersnaam']);
$offeredItems = Items::getSellerItems($profile_data_inspect_user['Gebruikersnaam']);
?>

<main class="verkopersPagina">
    <div class="VerkoperPagina jumbotron">
        <h2 class="display-5">Welkom op de verkoperspagina van <?=$profile_data_inspect_user['Gebruikersnaam']?></h2>
    </div>

    <div class="container">
        <h2>Profielgegevens</h2>
        <?php if($profile_data['Gebruikersnaam'] == $profile_data_inspect_user['Gebruikersnaam']) { ?>
        <div class="profielButtonBox text-right">
            <a class="profielButton" href="profile.php">Bekijk uw profiel</a>
        </div>
        <?php } ?>
        <div class="row">
            <div class="col-xl-4 col-md-6 col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Persoonsgegevens</h4>

                        <?php if(file_exists("upload/users/".$profile_data_inspect_user['Gebruikersnaam'].".png")):?>
                            <img src="upload/users/<?=$profile_data_inspect_user['Gebruikersnaam']?>.png" class="card-img" alt="profielfoto">
                        <?php else :?>
                            <img src="images/profilePicture.png" class="card-img" alt="profielfoto">
                        <?php endif;?>
                        <p><b>Naam: </b><?=$profile_data_inspect_user['Voornaam']?></p>
                        <p><b>Achternaam: </b><?=$profile_data_inspect_user['Achternaam']?></p>
                        <p><b>Emailadres: </b><?=$profile_data_inspect_user['Mailbox']?></p>
                        <p><b>Plaatsnaam: </b><?=$profile_data_inspect_user['Plaatsnaam']?></p>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6 col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Reviews</h4>
                        <div class="text-right">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                Toevoegen
                            </button>
                            <div class="dropdown-menu dropdown-menu-right animate slideIn">
                                <form class="voegReviewToeForm" method="POST" action="">
                                    <input type="hidden" name="token" value="<?=$token?>">
                                    <input type="hidden" name="user" value="<?=$_GET['id']?>">
                                    <div class="form-group col-xl-12">
                                        <label for="review">Voeg een review toe</label>
                                        <textarea class="form-control" name="review" id="review" rows="5"></textarea>
                                    </div>
                                    <button type="submit" name="action" value="review" class="form-control">Toevoegen</button>
                                </form>
                            </div>
                        </div>
                        <?php
                        foreach(User::getAllComments($profile_data_inspect_user['Gebruikersnaam']) as $comment):?>
                            <p><b><?=$comment['FeedbackGever']?></b><br><?=$comment['Feedback']?></p>
                        <?php endforeach;?>
                        <p><b>Admin</b><br>Dit is een goede verkoper, duidelijk en specifiek.</p>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6 col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Rating: <?=round(Database::getAvgRating($profile_data_inspect_user['Gebruikersnaam'])[""],2)?></h4>
                        <form class="ratingForm" action="" method="post">
                            <input type="hidden" name="token" value="<?=$token?>">
                            <input type="hidden" name="user" value="<?=$_GET['id']?>">
                            <div class="rate">
                                <input type="radio" id="star5" name="rate" value="5" />
                                <label for="star5" title="text">5 stars</label>
                                <input type="radio" id="star4" name="rate" value="4" />
                                <label for="star4" title="text">4 stars</label>
                                <input type="radio" id="star3" name="rate" value="3" />
                                <label for="star3" title="text">3 stars</label>
                                <input type="radio" id="star2" name="rate" value="2" />
                                <label for="star2" title="text">2 stars</label>
                                <input type="radio" id="star1" name="rate" value="1" />
                                <label for="star1" title="text">1 star</label>
                            </div>

                            <div class="text-center">
                                <button class="ratingButton" type="submit" name="action" value="review">Verzenden</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> <!-- Einde row -->

        <h2>Gewonnen veilingen</h2>
        <div class="row">
            <?php $atLeastOneAuctionWon = false;
            foreach($boughtItems as $item):
                if($item['VeilingGesloten'] == 'Wel'):
                    $atLeastOneAuctionWon = true; ?> <!-- true zetten zodat de melding: 'Er zijn nog geen gewonnen veilingen' niet kan worden weergegeven. -->

                    <div class="col-xl-4 col-md-6 col-sm-6">
                        <div class="card">
                            <a href='item.php?id=<?=$item['Voorwerpnummer'] ?>'>
                                <img src='upload/items/<?=$item['Voorwerpnummer'] ?>.png' class='card-img-top' alt='Productafbeelding'>
                            </a>
                            <div class="card-body">
                                <h5 class="card-title"><?=$item['Titel']?></h5>
                                <p class="card-text">€ <?=$item['prijs']?></p>
                                <p class="card-text"><?=$item['Beschrijving']?></p>
                                <a href='item.php?id=<?=$item['Voorwerpnummer']?>' class='card-link'>Meer informatie</a>
                            </div>
                        </div>
                    </div>
                <?php endif;
            endforeach;
            // Als er nog geen gewonnen veilingen zijn:
            if(!$atLeastOneAuctionWon): ?>
                <p class="geenGewonnenVeilingen">Er zijn nog geen gewonnen veilingen beschikbaar :(</p>
            <?php endif; ?>
        </div>

        <h2>Aangeboden veilingen</h2>
        <div class="row">
            <?php $offeredAtLeastOneItem = false;
            foreach($offeredItems as $item):
                $offeredAtLeastOneItem = true; ?> <!-- true zetten zodat de melding: 'Er zijn nog geen gewonnen veilingen' niet kan worden weergegeven. -->

                <div class="col-xl-4 col-md-6 col-sm-6">
                    <div class="card">
                        <a href='item.php?id=<?=$item['Voorwerpnummer'] ?>'>
                            <img src='upload/items/<?=$item['Voorwerpnummer'] ?>.png' class='card-img-top' alt='Productafbeelding'>
                        </a>
                        <div class="card-body">
                            <h5 class="card-title"><?=$item['Titel']?></h5>
                            <p class="card-text">€ <?=$item['Startprijs']?></p>
                            <p class="card-text"><?=$item['Beschrijving']?></p>
                            <a href='item.php?id=<?=$item['Voorwerpnummer']?>' class='card-link'>Meer informatie</a>
                        </div>
                    </div>
                </div>
            <?php endforeach;
            // Als er nog geen gewonnen veilingen zijn:
            if(!$offeredAtLeastOneItem): ?>
                <p class="geenAangebodenVeilingen">Er zijn nog geen aangeboden veilingen beschikbaar :(</p>
            <?php endif; ?>
        </div>

    </div>
</main>
