<?php
$settings = User::getSettings($_SESSION['name'])[0];
?>

<main class="updateGegevensPagina">
    <div class="container col-xl-12">
        <form class="updateForm" action="" method="post" enctype="multipart/form-data">
            <h2 class="text-center">Instellingen</h2>
            <?php if (isset($err)) echo $err; ?>
            <input type="hidden" name="token" value="<?= $token ?>">
            <p class="text-center">Pas uw Instellingen zodanig aan naar uw wensen.</p>
            <!-- ACCOUNTSETTINGS-->
            <div class="container">
                <h5>Account Settings</h5>
                <div class="form-row">
                    <!-- GEBRUIKERSNAAM -->
                    <div class="form-group col-md-5">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="recommendationsSetting" name="recommendationsSetting" <?php if($settings['recommendations']) echo "checked";?>>
                            <label class="custom-control-label" for="recommendationsSetting">Recommendations</label>
                        </div>
                    </div>
                    <div class="form-group col-md-5">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="darkmodeSetting" name="darkmodeSetting" <?php if($settings['darkmode']) echo "checked";?>>
                            <label class="custom-control-label" for="darkmodeSetting">Darkmode</label>
                        </div>
                    </div>
                    <div class="form-group col-md-1">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="notificationsSetting" name="notificationsSetting" <?php if($settings['notifications']) echo "checked";?>>
                            <label class="custom-control-label" for="notificationsSetting">Notificaties</label>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <!-- WACHTWOORD 2 -->
                    <div class="form-group col-md-5">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="superTrackingSetting" name="superTrackingSetting" <?php if($settings['superTracking']) echo "checked";?>>
                            <label class="custom-control-label" for="superTrackingSetting">SuperTracking</label>
                        </div>
                    </div>
                    <div class="form-group col-md-5">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="emailsSetting" name="emailsSetting" <?php if($settings['emails']) echo "checked";?>>
                            <label class="custom-control-label" for="emailsSetting">Emails</label>
                        </div>
                    </div>
                </div>
            </div>
            <!-- GA-TERUG-KNOP -->
            <div class="gaTerugKnopBox text-center">
                <a href="profile.php">Ga terug</a>
            </div>
            <!-- SUBMIT-KNOP -->
            <div class="text-center">
                <button class="updateButton" type="submit" name="action" value="settings">Update Settings</button>
            </div>
        </form>
    </div>

    <script>
        $(".custom-file-input").on("change", function () {
            var thumbnail = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(thumbnail);
        });
    </script>
</main>