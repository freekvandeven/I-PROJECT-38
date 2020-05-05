<main>
    <div class="container">
        <div class="row">
            <div class="col-xl-3 col-md-4 mt-2">
                <form>
                    <div class="form-group text-left">
                        <label for="inputBod">Bieden</label>
                        <input type="bod" class="form-control" id="inputBod" placeholder="&euro;">
                    </div>
                    <button type="submit" class="btn btn-outline-secondary">Plaats bod</button>
                </form>
                <ul class="list-group mt-4">
                    <li class="list-group-item"><strong>Ruurd</strong> &euro; 60</li>
                    <li class="list-group-item"><strong>Sanne</strong> &euro; 56</li>
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
                        <small class='text-muted'>Nog: 4min beschikbaar.</small>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-4 mt-2">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Verkoper</h4>
                        <img src="images/profilePicture.png" class="card-img" alt="profielfoto">
                        <!--<img src="upload/users/<?= $profile_data['Gebruikersnaam'] ?>.png" class="card-img" alt="profielfoto">-->
                        <p><b>Voornaam: </b><?= $profile_data['Voornaam'] ?></p>
                        <p><b>Achternaam: </b><?= $profile_data['Achternaam'] ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>

