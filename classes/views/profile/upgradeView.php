<?php
$profile_data = User::getUser($_SESSION['name']);
?>

<script src="https://cdn.jsdelivr.net/npm/darkmode-js@1.5.5/lib/darkmode-js.min.js"></script>
<script src="includes/darkMode.js"></script>

<main>
    <form id="login-form" class="upgradeForm" action="" method="post">
        <h2 class="text-center">Wordt een verkoper</h2>
        <!-- VERKOPER GEGEVENS-->
        <div class="container">
            <h5>Verkoper gegevens</h5>
            <?php if(isset($err))echo $err;?>
            <input type="hidden" name="token" value="<?=$token?>">
            <div class="form-row">
                <!-- BANK -->
                <div class="form-group col-md-6">
                    <label for="bank">Bank</label>
                    <input type="text" class="form-control" name="bank" id="bank" placeholder="Uw bank">
                </div>
                <!-- BANKREKENING -->
                <div class="form-group col-md-6">
                    <label for="bankrekening">Bankrekening</label>
                    <input type="text" class="form-control" name="bankrekening" id="bankrekening" placeholder="Uw bankrekening">
                </div>
                <!-- CONTROLEOPTIE -->
                <div class="form-group col-md-6">
                    <label for="controlenummer">ControleOptie</label>
                    <input type="text" class="form-control" name="controlenummer" id="controlenummer" placeholder="Uw controlenummer">
                </div>
                <!-- CREDITCARD -->
                <div class="form-group col-md-6">
                    <label for="creditcard">Creditcard</label>
                    <input type="text" class="form-control" name="creditcard" id="creditcard" placeholder="Uw creditcard">
                </div>

            </div>
        </div>
        <!-- GA-TERUG-KNOP -->
        <div class="form-group text-center">
            <a href="profile.php">Ga terug</a><br>
        </div>

        <!-- SUBMIT-KNOP -->
        <div class="form-group text-center">
            <button class="upgradeButton" type="submit" name="action" value="upgrade">Verkoper worden</button>
        </div>
    </form>
</main>