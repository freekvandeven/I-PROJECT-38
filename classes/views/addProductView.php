<?php
$user = User::getUser($_SESSION["name"]);
?>

<main>
    <div class="container">
        <div class='cardPreview card'>
            <div class="itemImage">
                <a href='#'>
                    <img id="img" alt="your image" width="100" height="100" class='card-img-top'/>
                </a>
            </div>
            <div class='card-body'>
                <h5 class='card-title' id="titel"></h5>
                <p class='card-text' id="beschrijving"></p>
                <p class="card-text" id="startprijs"></p>
                <a href='#' class='card-link'>Meer informatie</a>
            </div>
            <div class='card-footer'>
                <!-- Display the countdown timer in an element -->
                <p id="">N/A</p>
            </div>
        </div>
    </div>
    <form id="login-form" class="addProductForm" action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="token" value="<?= $token ?>">
        <h2 class="text-center">Product verkopen</h2>
        <div class="container">
            <!-- PRODUCTGEGEVENS -->
            <h5>Productgegevens</h5>
            <div class="form-row">
                <!-- TITEL -->
                <div class="form-group col-md-6">
                    <label for="Titel">Titel</label>
                    <input type="text" class="form-control input1" name="Titel" id="Titel" maxlength="25"
                           placeholder="Titel van uw product" autofocus required
                           value="<?php echo isset($_POST['Titel']) ? htmlspecialchars($_POST['Titel'], ENT_QUOTES) : ''; ?>">
                </div>
                <!-- RUBRIEK -->
                <div class="form-group col-md-6">
                    <label for="Rubriek">Rubriek</label>
                    <select class="custom-select" id="Rubriek" name="Rubriek"
                            required <?php echo isset($_POST['Rubriek']) ? htmlspecialchars($_POST['Rubriek'], ENT_QUOTES) : ''; ?>>
                        <?php
                        foreach (Items::getRubrieken() as $rubriek) {
                            echo "<option value='" . $rubriek['Rubrieknummer'] . "'>" . $rubriek['Rubrieknaam'] . "</option>";
                        } ?>
                    </select>
                </div>
                <!-- BESCHRIJVING -->
                <div class="form-group col-md-12">
                    <label for="Beschrijving">Beschrijving</label>
                    <input type="text" class="form-control input3" name="Beschrijving" id="Beschrijving"
                           placeholder="Beschrijving" maxlength="200"
                           required <?php echo isset($_POST['Beschrijving']) ? htmlspecialchars($_POST['Beschrijving'], ENT_QUOTES) : ''; ?>>
                </div>

                <!-- LOOPTIJD -->
                <div class="form-group col-md-6">
                    <label for="Looptijd">Looptijd: </label>
                    <div class="input-group">
                        <select class="form-control" name="Looptijd" id="Looptijd">
                                required <?php echo isset($_POST['Looptijd']) ? htmlspecialchars($_POST['Looptijd'], ENT_QUOTES) : ''; ?>>
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
                <!-- THUMBNAIL UPLOADEN -->
                <div class="form-group col-md-6">
                    <label for="thumbnail">Thumbnail</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="thumbnail" name="thumbnail" accept="image/*"
                               onchange="document.getElementById('img').src = window.URL.createObjectURL(this.files[0])
                                          $('#img').show();"
                               required <?php echo isset($_POST['thumbnail']) ? htmlspecialchars($_POST['thumbnail'], ENT_QUOTES) : ''; ?>>
                        <label class="custom-file-label" for="img" data-browse="Bestand kiezen">Voeg je document
                            toe</label>
                    </div>
                </div>
                <!-- FOTO UPLOADEN -->
                <div class="form-group col-md-6">
                    <label for="img">Optionele foto's (max. 5)</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="img" name="img" accept="image/*"
                               onchange="document.getElementById('img').src = window.URL.createObjectURL(this.files[0])
                                          $('#img').show();"
                               required <?php echo isset($_POST['img']) ? htmlspecialchars($_POST['img'], ENT_QUOTES) : ''; ?>>
                        <label class="custom-file-label" for="img" data-browse="Bestand kiezen">Voeg je document
                            toe</label>
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
                        <input type="text" class="form-control input2" id="Startprijs" name="Startprijs" maxlength="12"
                               required <?php echo isset($_POST['Startprijs']) ? htmlspecialchars($_POST['Startprijs'], ENT_QUOTES) : ''; ?>>
                    </div>
                </div>

                <!-- BETALINGSWIJZE -->
                <div class="form-group col-md-6">
                    <label for="Betalingswijze">Betalingswijze</label>
                    <select class="form-control" id="Betalingswijze" name="Betalingswijze"
                            required <?php echo isset($_POST['Betalingswijze']) ? htmlspecialchars($_POST['Betalingswijze'], ENT_QUOTES) : ''; ?>>
                        <option value="Contact">Contact</option>
                        <option value="Bank">Bank</option>
                        <option value="Anders">Anders</option>
                    </select>
                </div>

                <!-- BETALINGSINSTRUCTIES -->
                <div class="form-group col-md-12">
                    <label for="Betalingsinstructie">Betalingsinstructies: </label>
                    <input type="text" class="form-control" name="Betalingsinstructie" id="Betalingsinstructie" maxlength="100"
                           required <?php echo isset($_POST['Betalingsinstructie']) ? htmlspecialchars($_POST['Betalingsinstructie'], ENT_QUOTES) : ''; ?>>
                </div>

                <!-- VERZENDINSTRUCTIES -->
                <div class="form-group col-md-12">
                    <label for="Verzendinstructies">Verzendinstructies: </label>
                    <input type="text" class="form-control" name="Verzendinstructies" id="Verzendinstructies"maxlength="100"
                           required <?php echo isset($_POST['Verzendinstructies']) ? htmlspecialchars($_POST['Verzendinstructies'], ENT_QUOTES) : ''; ?>>
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
    <script>
        $('#img').hide();
        $("input[class*='input1']").keyup(function () {
            $('#titel').html($(this).val());
        });
        $("input[class*='input2']").keyup(function () {
            $('#startprijs').html("€"+$(this).val());
        });
        $("input[class*='input3']").keyup(function () {
            var shortText = jQuery.trim($(this).val()).substring(0, 10)
                .trim(this) + "...";
            $('#beschrijving').html(    shortText);
        });
    </script>
</main>