<?php
$maxPhotos = 5;
$images = generateImageLink($item['Voorwerpnummer'], false);
?>

<main class="veilingBekijkenPagina">
    <div class="container">
        <div class="row">
            <div class="itemInformatie col-xl-8 col-md-8">
                <div class="card">
                    <div class='card-body'>
                        <h4 class="card-header text-center"><?=$item['Titel']?>
                            <?php if(!empty($_SESSION)&&$_SESSION['admin']==true): ?>
                            <div class="row">
                                    <form class="voegFavorietToeForm col-6" method="post" action="">
                                        <input type="hidden" name="token" value="<?= $token ?>">
                                        <input type="hidden" name="voorwerp" value="<?= $item['Voorwerpnummer'] ?>">
                                        <div class="voegToeAanFavorietenButtonBox text-left">
                                            <button type="submit" name="action" value="follow" class="voegToeAanFavorietenButton">Favorieten+</button>
                                        </div>
                                    </form>

                                    <form method="post" action="" class="col-6">
                                        <input type="hidden" name="token" value="<?= $token ?>">
                                        <input type="hidden" name="voorwerp" value="<?= $item['Voorwerpnummer'] ?>">
                                        <div class="verwijderVeilingButtonBox text-right">
                                            <button class="verwijderVeilingButton" type="submit" name="action" value="delete">Veiling verwijderen</button>
                                        </div>
                                    </form>
                            </div>
                            <?php endif; ?>
                        </h4>

                        <div id="carouselExampleIndicators" class="carousel slide">
                            <ol class="carousel-indicators">
                                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                <?php
                                for($i=1; $i<count($images); $i++) { // pointer to next image ?>
                                        <li data-target="#carouselExampleIndicators" data-slide-to="<?=$i?>"></li>
                                    <?php
                                }
                                ?>

                            <!-- Tekent eerste afbeelding -->
                            </ol>
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <a href="#image0">
                                        <img class="d-block w-100" src="<?=$images[0]?>" alt="Thumbnail">
                                    </a>
                                </div>

                                <!-- Foto 1 vergroot -->
                                <div class="lightbox-target" id="image0">
                                    <img src="<?=$images[0]?>">
                                    <a class="lightbox-close" href="#"></a>
                                </div>

                                <!-- Tekent de andere afbeeldingen -->
                                <?php
                                for($i=1; $i<count($images); $i++): ?>
                                    <div class="carousel-item">
                                        <a href="#image<?php echo $i ?>" >
                                            <img class="d-block w-100" id="image-<?=$i?>" src="<?=$images[$i];?>" alt="Productfoto">
                                        </a>
                                    </div>
                                <?php endfor; ?>

                                <!-- Vergroot de rest van de afbeeldingen -->
                                <?php for($i=1; $i<count($images); $i++) : ?>
                                    <div class="lightbox-target" id="image<?php echo $i ?>">
                                        <img src="<?=$images[$i];?>">
                                        <a class="lightbox-close" href="#"></a>
                                    </div>
                                <?php endfor; ?>


                            </div>

                            <!-- Zijn er meer dan 1 afbeeldingen? -->
                            <?php
                            if(count($images) > 1): ?>
                            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                            <?php endif; ?>
                        </div>

                        <p class='card-text'><?= $item['Beschrijving'] ?></p>
                    </div>
                    <div class='card-footer'>
                        <small class='text-muted'></small>
                        <p id="timer">N/A</p>
                        <p class="aantalKeerBekeken text-right"><?=$item['Views'] ?> keer bekeken</p>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="bieden card-header text-center">Bieden</h4>
                        <p>Biedingen</p>

                        <ul class="biedingen text-center col-xl-10 offset-xl-1">
                            <?php foreach($bids as $bid){
                              $user = User::getUser($bid['Gebruiker']);
                              if(!empty($user)){
                                $user = $user['Voornaam'];
                                $price = number_format($bid['Bodbedrag'], 2, ',','.');
                              }
                              else{
                                $user = "Deleted User";
                                $price = "<del>".number_format($bid['Bodbedrag'], 2, ',','.')."</del>";
                              }
                              echo "<li class='list-group-item'><strong>" .$user. "</strong> &euro;" . $price ."</li>";
                              } ?>
                            <li class="list-group-item"><strong>Startprijs: </strong> &euro;<?=number_format($item['Startprijs'], 2, ',','.')?></li>
                        </ul>

                        <form method="post" action="">
                            <input type="hidden" name="token" value="<?= $token ?>">

                            <label for="inputBod" class="plaatsUwBod">Plaats uw bod</label>
                            <div class="invullenBod input-group col-xl-10 offset-xl-1">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">€</span>
                                </div>
                                <input type="hidden" name="voorwerp" value="<?= $item['Voorwerpnummer'] ?>">
                                <input type="number" class="inputBod form-control" id="inputBod" name="bid" min="0" required>
                            </div>
                            <div class="buttonBox text-center col-xl-10 offset-xl-1">
                                <button type="submit" class="btn btn-outline-secondary">Plaats bod</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-xl-8 col-md-6">
                <div class="verkoper">
                    <div class="card">
                        <div class="card-body">
                            <a href="profile.php?id=<?= $profile_data['Gebruikersnaam']?>"><h4 class="card-header text-center">Verkoper</h4></a>
                            <div class="verkoperInformatieBox row">
                                <div class="profielfoto col-xl-6">
                                    <a href="profile.php?id=<?= $profile_data['Gebruikersnaam']?>">
                                        <img src="<?=getProfileImage($profile_data['Gebruikersnaam'])?>" class="card-img" alt="profielfoto">
                                    </a>
                                </div>
                                <div class="verkoperInformatie col-xl-6">
                                    <p><b>Voornaam: </b><?= $profile_data['Voornaam'] ?></p>
                                    <p><b>Achternaam: </b><?= $profile_data['Achternaam'] ?></p>
                                    <p><b>Rating: </b><?= round(Database::getAvgRating($profile_data['Gebruikersnaam'])[""], 2) ?></p>
                                    <?php
                                    if(empty(Seller::ratedUser($_SESSION['name'],$_GET['id']))&&!empty(Items::soldToUser($_SESSION['name'], $_GET['id']))): ?>
                                        <form class="ratingForm" action="" method="post">
                                            <input type="hidden" name="token" value="<?= $token ?>">
                                            <input type="hidden" name="user" value="<?= $_GET['id'] ?>">
                                            <div class="rate">
                                                <input type="radio" id="star5" name="rate" value="5"/>
                                                <label for="star5" title="text">5 stars</label>
                                                <input type="radio" id="star4" name="rate" value="4"/>
                                                <label for="star4" title="text">4 stars</label>
                                                <input type="radio" id="star3" name="rate" value="3"/>
                                                <label for="star3" title="text">3 stars</label>
                                                <input type="radio" id="star2" name="rate" value="2"/>
                                                <label for="star2" title="text">2 stars</label>
                                                <input type="radio" id="star1" name="rate" value="1"/>
                                                <label for="star1" title="text">1 star</label>
                                            </div>

                                            <div class="text-center">
                                                <button class="ratingButton" type="submit" name="action" value="review">Verzenden
                                                </button>
                                            </div>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                    </div>
                    <script>
                        <?php $tijdstip = $item['LooptijdEindeTijdstip']; //get the countdown date ?>
                        setupCountDown('timer', new Date("<?=explode(".", $tijdstip)[0];?>")); // start the countdowntimer
                </script>
            </div>
        </div>
    </div>

</main>

