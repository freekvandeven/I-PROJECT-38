<main class="veilingBekijkenPagina">
    <div class="container">

        <div class="row">
            <div class="itemInformatie col-xl-8 col-md-8">
                <div class="card">
                    <div class='card-body'>
                        <h4 class="card-header text-center"><?=$item['Titel']?></h4>
                        <img src='upload/items/<?=$item['Voorwerpnummer']?>.png' class='card-img-top' alt='Productnaam'>
                        <p class='card-text'><?= $item['Beschrijving'] ?></p>
                    </div>
                    <div class='card-footer'>
                        <small class='text-muted'></small>
                        <p id="timer">appel</p>
                        <p class="aantalKeerBekeken text-right">1120 keer bekeken</p>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-header text-center">Bieden</h4>
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
                        <a href="profile.php?id=<?= $profile_data['Gebruikersnaam']?>">
                            <div class="card-body">
                                <h4 class="card-header text-center">Verkoper</h4>
                                <div class="verkoperInformatieBox row">
                                    <div class="profielfoto col-xl-6">
                                        <?php if(file_exists("upload/users/".$profile_data['Gebruikersnaam'].".png")):?>
                                            <img src="upload/users/<?=$profile_data['Gebruikersnaam']?>.png" class="card-img" alt="profielfoto">
                                        <?php else :?>
                                            <img src="images/profilePicture.png" class="card-img" alt="profielfoto">
                                        <?php endif; ?>
                                    </div>
                                    <div class="verkoperInformatie col-xl-6">
                                        <p><b>Voornaam: </b><?= $profile_data['Voornaam'] ?></p>
                                        <p><b>Achternaam: </b><?= $profile_data['Achternaam'] ?></p>
                                        <p><b>Rating: </b><?=round(Database::getAvgRating($profile_data['Gebruikersnaam'])[""],2)?></p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <script>
                        <?php
                        $datum = $item['LooptijdEindeDag'];
                        $tijdstip = $item['LooptijdEindeTijdstip'];
                        $time = explode(" ", $datum)[0] . " " . explode(" ", $tijdstip)[1];
                        echo "var my_date= '" . explode( ".",$time)[0] . "';\n";
                        ?>
                        my_date = my_date.replace(/-/g, "/");
                        var d = new Date(my_date);
                        setupCountDown('timer', d);
                    //var countDownDate = new Date(<?=explode(" ", $item['LooptijdEindeTijdstip'])[1]?>).getTime();
                </script>
                <?php if($sent == false) : ?>
                    <form action="" method="POST">
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
                        <button name="action" value="raten">Verzenden</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>

</main>

