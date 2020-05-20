<?php
$user = User::getUser($_SESSION["name"]);
$maxAmountOptionalPhotos = 5;
?>

<main class="addProductPagina">

    <form id="addProduct" class="addProductForm" action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="token" value="<?= $token ?>">
        <h2 class="text-center font-weight-normal col-sm-6 offset-sm-3 col-4 offset-4">Product verkopen</h2>
        <div class="productContainer container">
            <div class="row">
                <div class="productGegevens col-lg-6">
                    <!-- PRODUCTGEGEVENS -->
                    <h4>Productgegevens</h4>
                    <div class="form-row">
                        <!-- TITEL -->
                        <div class="form-group col-md-12">
                            <label for="Titel">Titel</label>
                            <input type="text" class="form-control input1" name="Titel" id="Titel" maxlength="100"
                                   placeholder="Titel van uw product" autofocus required
                                   value="<?php echo isset($_POST['Titel']) ? htmlspecialchars($_POST['Titel'], ENT_QUOTES) : ''; ?>">
                        </div>

                        <!-- BESCHRIJVING -->
                        <div class="form-group col-md-12">
                            <label for="Beschrijving">Beschrijving</label>
                            <textarea class="form-control input3" name="Beschrijving" id="Beschrijving"
                                      placeholder="Beschrijving" maxlength="4000" rows="4"
                                      required <?php echo isset($_POST['Beschrijving']) ? htmlspecialchars($_POST['Beschrijving'], ENT_QUOTES) : ''; ?>></textarea>
                        </div>

                        <!-- RUBRIEK -->
                        <div class="form-group col-md-12">
                            <label for="Rubriek">Rubriek</label>
                            <select class="custom-select" id="Rubriek" name="Rubriek"
                                    required <?php echo isset($_POST['Rubriek']) ? htmlspecialchars($_POST['Rubriek'], ENT_QUOTES) : ''; ?>>
                                <?php
                                foreach (Items::getRubrieken() as $rubriek) {
                                    echo "<option value='" . $rubriek['Rubrieknummer'] . "'>" . $rubriek['Rubrieknaam'] . "</option>";
                                } ?>
                            </select>
                        </div>

                        <!-- STARTPRIJS -->
                        <div class="form-group col-md-6">
                            <label for="Startprijs">Startprijs</label>
                            <div class="input-group col-mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">€</span>
                                </div>
                                <input type="number" class="form-control input2" id="Startprijs" name="Startprijs"
                                       min="0" max="9999999999999" placeholder="Startprijs"
                                       required <?php echo isset($_POST['Startprijs']) ? htmlspecialchars($_POST['Startprijs'], ENT_QUOTES) : ''; ?>>
                            </div>
                        </div>

                        <!-- LOOPTIJD -->
                        <div class="form-group col-md-6">
                            <label for="Looptijd">Looptijd: </label>
                            <div class="input-group">
                                <select class="form-control" name="Looptijd" id="Looptijd">
                                    required <?php echo isset($_POST['Looptijd']) ? htmlspecialchars($_POST['Looptijd'], ENT_QUOTES) : ''; ?>
                                    >
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
                        <div class="form-group col-md-12">
                            <label for="img">Thumbnail</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="thumbnail" name="thumbnail"
                                       accept="image/*"
                                       required <?php echo isset($_POST['thumbnail']) ? htmlspecialchars($_POST['thumbnail'], ENT_QUOTES) : ''; ?>
                                       onchange="document.getElementById('imgPreview').src = window.URL.createObjectURL(this.files[0])
                                       $('#imgPreview').show();">
                                <label class="custom-file-label" for="thumbnail" data-browse="Zoeken">Voeg thumbnail
                                    toe</label>
                            </div>
                        </div>
                        <!-- FOTO UPLOADEN -->
                        <div class="form-group col-md-12">
                            <label for="img">Optionele foto's</label>
                            <div class="custom-file">
                                <input type="file" class="multipleImages custom-file-input" id="img" name="img[]"
                                       accept="image/*" required
                                       multiple <?php echo isset($_POST['img']) ? htmlspecialchars($_POST['img'], ENT_QUOTES) : ''; ?>>
                                <label class="custom-file-label" for="img" data-browse="Zoeken">Voeg foto's toe (max.
                                    5)</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="cardPreviewBox col-lg-4 offset-lg-1 col-md-4 offset-md-4 col-sm-6 offset-sm-3 col-6 offset-3">
                    <h4 class="text-center">Uw veiling</h4>
                    <div class='card col-lg-12'>
                        <div class="itemImage">
                            <img id="imgPreview" alt="Uw thumbnail" class='card-img-top'>
                        </div>
                        <div class='card-body'>
                            <h5 class='card-title' id="titel"></h5>
                            <p class='card-text' id="beschrijving"></p>
                            <p class="card-text" id="startprijs"></p>
                            <a href='#' class='card-link'>Meer informatie</a>
                        </div>
                        <div class='card-footer'>
                            <p id="">N/A</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <!-- BETALINGSGEGEVENS -->
            <h4>Betalingsgegevens</h4>
            <div class="form-row">
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
            </div>

            <div class="form-row">
                <!-- BETALINGSINSTRUCTIES -->
                <div class="form-group col-md-6">
                    <label for="Betalingsinstructie">Betalingsinstructies: </label>
                    <textarea class="form-control" name="Betalingsinstructie" id="Betalingsinstructie" maxlength="25"
                              rows="4"
                              placeholder="Betalingsinstructies" <?php echo isset($_POST['Betalingsinstructie']) ? htmlspecialchars($_POST['Betalingsinstructie'], ENT_QUOTES) : ''; ?>></textarea>
                </div>

                <!-- VERZENDINSTRUCTIES -->
                <div class="form-group col-md-6">
                    <label for="Verzendinstructies">Verzendinstructies: </label>
                    <textarea class="form-control" name="Verzendinstructies" id="Verzendinstructies" maxlength="50"
                              rows="4"
                              placeholder="Verzendinstructies" <?php echo isset($_POST['Verzendinstructies']) ? htmlspecialchars($_POST['Verzendinstructies'], ENT_QUOTES) : ''; ?>></textarea>
                </div>
            </div>
        </div>

        <!-- GA-TERUG-KNOP -->
        <div class="form-group text-center">
            <a href="profile.php">Ga terug</a>
        </div>

        <!-- SUBMIT-KNOP -->
        <div class="form-group text-center">
            <button class="addProductButton" type="submit" name="action" value="verzenden" id="submit">Aanbieden</button>
        </div>
    </form>

    <script>
        $(".custom-file-input").on("change", function () {
            var thumbnail = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(thumbnail);
        });

        $(".multipleImages").on("change", function () {
            if ($("#img")[0].files.length > <?=$maxAmountOptionalPhotos?>) {
                var aantalFotosGeselecteerd = $("#img")[0].files.length;
                alert("Je hebt " + aantalFotosGeselecteerd + " optionele foto's geselecteerd. De eerste 5 worden meegenomen.");
            }
        });


        $('#imgPreview').hide();
        $("input[class*='input1']").keyup(function () {
            $('#titel').html($(this).val());
        });
        $("input[class*='input2']").keyup(function () {
            $('#startprijs').html("€" + $(this).val());
        });
        $("textarea[class*='input3']").keyup(function () {
            var shortText = jQuery.trim($(this).val()).substring(0, 15)
                .trim(this) + "...";
            $('#beschrijving').html(shortText);
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/darkmode-js@1.5.5/lib/darkmode-js.min.js"></script>
    <script src="includes/darkMode.js"></script>
</main>