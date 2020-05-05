<?php
$user = User::getUser($_SESSION["name"]);
?>

<main>
    <form id="login-form" class="addProductForm" action="" method="post" enctype="multipart/form-data">
        <h2 class="text-center">Product verkopen</h2>
        <div class="container">
            <!-- PRODUCTGEGEVENS -->
            <h5>Productgegevens</h5>
            <div class="form-row">
                <!-- TITEL -->
                <div class="form-group col-md-6">
                    <label for="Titel">Titel</label>
                    <input type="text" class="form-control" name="Titel" id="Titel" placeholder="Titel van uw product" autofocus required>
                </div>
                <!-- RUBRIEK -->
                <div class="form-group col-md-6">
                    <label for="Rubriek">Rubriek</label>
                    <select  class="form-control" id="Rubriek" name="Rubriek" required>
                        <option value="Auto's, boten en motoren">Autos, boten en motoren</option>
                        <option value="Baby">Baby</option>
                        <option value="Muziek en Instrumenten">Muziek en instrumenten</option>
                        <option value="Elektronica">Elektronica</option>
                        <option value="Mode">Mode</option>
                    </select>
                </div>
                <!-- BESCHRIJVING -->
                <div class="form-group col-md-12">
                    <label for="Beschrijving">Beschrijving</label>
                    <input type="text" class="form-control" name="Beschrijving" id="Beschrijving" placeholder="Beschrijving" required>
                </div>

                <!-- LOOPTIJD -->
                <div class="form-group col-md-6">
                    <label for="Looptijd">Looptijd: </label>
                    <div class="input-group">
                        <select class="form-control" name="Looptijd" id="Looptijd" required>
                            <option value="1">1</option>
                            <option value="3">3</option>
                            <option value="5" selected="selected">5</option>
                            <option value="7">7</option>
                            <option value="10">10</option>
                        </select>
                        <div class="input-group-append">
                            <span class="input-group-text">dagen</span>
                        </div>
                    </div>
                </div>

                <!-- FOTO UPLOADEN -->
                <div class="form-group col-md-6">
                    <label for="img">Foto</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="img" name="img" accept="image/*" required>
                        <label class="custom-file-label" for="img" data-browse="Bestand kiezen">Voeg je document toe</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <!-- BETALINGSGEGEVENS -->
            <h5>Betalingsgegevens</h5>
            <div class="form-row">
                <!-- STARTPRIJS -->
                <div class="col-md-6">
                    <label for="Startprijs">Startprijs</label>
                    <div class="input-group col-mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">€</span>
                        </div>
                        <input type="text" class="form-control" id="Startprijs" name="Startprijs" required>
                    </div>
                </div>

                <!-- BETALINGSWIJZE -->
                <div class="form-group col-md-6">
                    <label for="Betalingswijze">Betalingswijze</label>
                    <select class="form-control" id="Betalingswijze" name="Betalingswijze" required>
                        <option value="Contact">Contact</option>
                        <option value="Bank">Bank</option>
                        <option value="Anders">Anders</option>
                    </select>
                </div>

                <!-- BETALINGSINSTRUCTIES -->
                <div class="form-group col-md-12">
                    <label for="Betalingsinstructie">Betalingsinstructies: </label>
                    <input type="text" class="form-control" name="Betalingsinstructie" id="Betalingsinstructie" required>
                </div>

                <!-- VERZENDINSTRUCTIES -->
                <div class="form-group col-md-12">
                    <label for="Verzendinstructies">Verzendinstructies: </label>
                    <input type="text" class="form-control" name="Verzendinstructies" id="Verzendinstructies" required>
                </div>
            </div>
        </div>

        <!-- GA-TERUG-KNOP -->
        <div class="form-group text-center">
            <a href="profile.php">Ga terug</a>
        </div>

        <!-- SUBMIT-KNOP -->
        <div class="form-group text-center">
            <button class="addProductButton" type="submit" name="action" value="verzenden">Aanbieden</button>
        </div>
    </form>
</main>