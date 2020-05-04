<main>
    <form id="login-form" class="addProductForm" action="" method="post" enctype="multipart/form-data">
        <h2 class="text-center">Product verkopen</h2>
        <div class="container">
            <!-- PRODUCTGEGEVENS -->
            <h5>Productgegevens</h5>
            <div class="form-row">
                <!-- TITEL -->
                <div class="form-group col-md-6">
                    <label for="bank">Titel</label>
                    <input type="text" class="form-control" name="bank" id="bank" placeholder="Uw product" autofocus required>
                </div>
                <!-- RUBRIEK -->
                <div class="form-group col-md-6">
                    <label for="rubriek">Rubriek</label>
                    <select  class="form-control" id="rubriek" name="categorie" required>
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
                    <label for="looptijd">Looptijd: </label>
                    <select class="form-control" id="looptijd" name="looptijd" required>
                        <option value="1">1</option>
                        <option value="3">3</option>
                        <option value="5" selected="selected">5</option>
                        <option value="7">7</option>
                        <option value="10">10</option>
                    </select>
                </div>

                <!-- FOTO UPLOADEN -->
                <div class="form-group col-md-6">
                    <label for="img">Foto uploaden</label>
                    <input type="file" class="form-control" name="img" id="img" accept="image/*" required>
                </div>
            </div>
        </div>

        <div class="container">
            <!-- BETALINGSGEGEVENS -->
            <h5>Betalingsgegevens</h5>
            <div class="form-row">
                <!-- STARTPRIJS -->
                <div class="form-group col-md-6">
                    <label for="startprijs">Startprijs</label>
                    <input type="number" class="form-control" name="startprijs" id="startprijs" min="0" required>
                </div>

                <!-- BETALINGSWIJZE -->
                <div class="form-group col-md-6">
                    <label for="betalingswijze">Betalingswijze</label>
                    <select class="form-control" id="betalingswijze" name="betalingswijze" required>
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
            <a href="profile.php">Ga terug</a><br>
        </div>

        <!-- SUBMIT-KNOP -->
        <div class="form-group text-center">
            <button class="addProductButton" type="submit" name="action" value="verzenden">Aanbieden</button>
        </div>
    </form>
</main>