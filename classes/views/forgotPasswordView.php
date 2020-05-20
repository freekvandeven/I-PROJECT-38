<?php

?>

<main class="forgotPasswordPagina">
    <div class="container">
        <h2 class="wachtwoordVergetenTitel">Wachtwoord vergeten</h2>
        <?php
        echo (empty($_POST['email']))?"
            <h5 class=\"text-center\">Vul uw emailadres in.</h5>
            <h5 class=\"text-center\">Wij sturen u een email met verdere instructies.</h5>":"
            <h5 class=\"text-center\">Als dit een geldig email adress was dan hebben wij een mail verstuurd om uw wachtwoord te resetten.</h5>"
        ?>
        <form class="wachtwoordVergetenForm" action="" method="POST">
            <div class="centerForm">
                <div class="emailContainer col-md-9">
                    <label for="email">Emailadres</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Uw emailadres" required>
                </div>

                <div class="form-group text-center">
                    <p class="gaTerugKnop"><a href="login.php">Ga terug</a></p>
                </div>

                <div class="form-group text-center">
                    <button class="wachtwoordVergetenButton" type="submit" name="submit" value="update">Verzend email</button>
                </div>

            </div>
        </form>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/darkmode-js@1.5.5/lib/darkmode-js.min.js"></script>
<script src="includes/darkMode.js"></script>
