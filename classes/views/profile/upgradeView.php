<?php
$profile_data = getUser($_SESSION['name']);
?>
<main>
    <form id="login-form" class="verkoperForm" action="" method="post">
        <h2 class="text-center">Wordt een verkoper</h2>
        <!-- VERKOPER GEGEVENS-->
        <div class="container">
            <h5>Verkoper gegevens</h5>
            <?php if(isset($err))echo $err;?>
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
            <input type="submit" name="action" value="Bevestigen">
        </div>
    </form>
</main>