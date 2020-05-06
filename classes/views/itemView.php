<main>
    <div class="container">
        <div class="row">
            <div class="col-xl-3 col-md-4 mt-2">
                <form method="post" action="">
                    <label for="inputBod">Bieden</label>
                    <div class="input-group text-left">
                        <div class="input-group-prepend">
                            <span class="input-group-text">€</span>
                        </div>
                        <input type="hidden" name="voorwerp" value="<?=$item['Voorwerpnummer']?>">
                        <input type="text" class="form-control" id="inputBod" name="bit" required>
                    </div>
                    <button type="submit" class="btn btn-outline-secondary">Plaats bod</button>
                </form>
                <ul class="list-group mt-4">
                    <?php foreach($bids as $bid){
                        echo "<li class='list-group-item'><strong>" . User::getUser($bid['Gebruiker'])["Voornaam"] . "</strong> &euro;" . $bid['Bodbedrag'] ."</li>";
                    } ?>
                    <li class="list-group-item"><strong>Startprijs</strong> &euro;<?=$item['Startprijs']?></li>
                </ul>
            </div>
            <div class="col-xl-6 col-md-4 mt-2">
                <div class='card'>
                    <div class='card-body'>
                        <h4 class="card-title"><?=$item['Titel']?></h4>
                        <img src='upload/items/<?=$item['Voorwerpnummer']?>.png' class='card-img-top' alt='Productnaam'>
                        <p class='card-text'><?= $item['Beschrijving'] ?></p>
                    </div>
                    <div class='card-footer'>
                        <small class='text-muted'></small>
                        <p id="timer"></p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-4 mt-2">
                <div class="card">
                    <a style="text-decoration: none; color: inherit;" href="profile.php?id=<?= $profile_data['Gebruikersnaam']?>">
                    <div class="card-body">
                        <h4 class="card-title">Verkoper</h4>
                        <img src="images/profilePicture.png" class="card-img" alt="profielfoto">
                        <!--<img src="upload/users/<?= $profile_data['Gebruikersnaam'] ?>.png" class="card-img" alt="profielfoto">-->
                        <p><b>Voornaam: </b><?= $profile_data['Voornaam'] ?></p>
                        <p><b>Achternaam: </b><?= $profile_data['Achternaam'] ?></p>
                    </div>
                    </a>
                </div>
                <button id='btn'>Klik om alle reviews te bekijken! </button>
                <ul id="list">
                    <li>Amos: een kwalitatief uitstekend product, maar ben wel 100 miljoen kwijt</li>
                    <li>Joons: hallo ik ben joons en ik kief met mijn matties</li>
                    <li>Freek: hallo ik ben freek joo it is your homie</li>
                    <li>Anthony: joo ik ben anthony en ik houd van lekker zuupen</li>
                </ul>

                <script>
                    const button = document.getElementById("btn");
                    const list = document.getElementById("list");

                    list.style.display = "none";

                    button.addEventListener("click", (event) => {
                        if(list.style.display == "none"){
                            list.style.display = "block";
                        } else {
                            list.style.display = "none";
                        }
                    })
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
            </div>
        </div>
    </div>

</main>

