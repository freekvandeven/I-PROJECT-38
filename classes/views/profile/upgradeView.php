<?php
$profile_data = getUser($_SESSION['name']);
?>
<main>
    <form id="login-form" class="registerForm" action="" method="post">
        <h2 class="text-center">Wordt een verkoper</h2>
        <!-- VERKOPER GEGEVENS-->
        <div class="container">
            <h5>Verkoper gegevens</h5>
            <div class="form-row">
                <!-- BANK -->
                <div class="form-group col-md-6">
                    <label for="bank">Bank</label>
                    <input type="text" class="form-control" id="bank" placeholder="Uw bank">
                </div>
                <!-- BANKREKENING -->
                <div class="form-group col-md-6">
                    <label for="bankrekening">Bankrekening</label>
                    <input type="text" class="form-control" id="bankrekening" placeholder="Uw bankrekening">
                </div>
                <!-- CONTROLEOPTIE -->
                <div class="form-group col-md-6">
                    <label for="controlenummer">ControleOptie</label>
                    <input type="text" class="form-control" id="controlenummer" placeholder="Uw controlenummer">
                </div>
                <!-- CREDITCARD -->
                <div class="form-group col-md-6">
                    <label for="creditcard">Creditcard</label>
                    <input type="text" class="form-control" id="creditcard" placeholder="Uw creditcard">
                </div>

            </div>
        </div>
        <!-- SUBMIT-KNOP -->
        <div class="form-group text-center">
            <input type="submit" name="action" value="upgrade">
        </div>
    </form>
    <a href="profile.php">Ga terug</a>
</main>