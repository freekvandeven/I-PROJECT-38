        <!-- Footer -->
        <footer>
            <div class="bovenstukFooter">
                <div class="container">
                    <div class="row py-4 d-flex align-items-center">

                        <!-- Tekst boven de footer -->
                        <div class="col-md-6 col-lg-5 text-center text-md-left mb-4 mb-md-0">
                            <h5 class="mb-0">Deel onze website op social media!</h5>
                        </div>

                        <!-- Social media links -->
                        <div class="col-md-6 col-lg-7 text-center text-md-right">
                            <!-- Facebook -->
                            <a href="https://facebook.com/share/" target="_blank"><img src="images/footerimages/facebook.png" alt="Facebook logo"></a>
                            <!-- Twitter -->
                            <a href="https://twitter.com/share?text=Bekijk nu de beste veilingssite van Nederland!&url=https://<?= $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']?>"><img src="images/footerimages/twitter.png" alt="Twitter logo"></a>
                            <!-- Instagram -->
                            <a href="https://instagram.com/han.nl" target="_blank"><img src="images/footerimages/instagram.png" alt="Instagram logo"></a>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Footer Links -->
            <div class="container text-center text-md-left mt-5">
                <div class="row mt-3">
                    <!-- 1e kolom -->
                    <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
                        <h5>EenmaalAndermaal</h5>
                        <hr class="accent-2 mb-4 mt-0 d-inline-block mx-auto">
                        <p>Bij EenmaalAndermaal is de klant koning. Daarom kan de klant zijn eigen producten aanbieden en op die van een ander bieden.</p>
                    </div>

                    <!-- 2e kolom -->
                    <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                        <h5>Handige links</h5>
                        <hr class="accent-2 mb-4 mt-0 d-inline-block mx-auto">
                        <p><a href="profile.php">Jouw account</a></p>
                        <p><a href="catalogus.php">Veilingen bekijken</a></p>
                        <p><a href="addProduct.php">Product verkopen</a></p>
                        <p><a href="footer.php?action=FAQ">Help</a></p>
                    </div>

                    <!-- 3e kolom -->
                    <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                        <h5>Over ons</h5>
                        <hr class="accent-2 mb-4 mt-0 d-inline-block mx-auto">
                        <p><a href="footer.php?action=profit">Verdienmodel</a></p>
                        <p><a href="footer.php?action=advertise">Adverteren</a></p>
                        <p><a href="footer.php?action=AVG">Algemene voorwaarden</a></p>
                        <p><a href="footer.php?action=vacancies">Vacatures</a></p>
                    </div>

                    <!-- 4e kolom -->
                    <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                        <h5>Contact</h5>
                        <hr class="accent-2 mb-4 mt-0 d-inline-block mx-auto">
                        <p><img src="images/footerimages/plaats.png" alt="Home image">42nd Street, New York, New York</p>
                        <p><a href="mailto:anthonyvago2001@gmail.com"><img src="images/footerimages/mail.png" alt="Email image">info@EenmaalAndermaal.com</a></p>
                        <p><a href="tel:+31 6 123456"><img src="images/footerimages/telefoon.png" alt="Phone image">+31 6 123456</a></p>
                        <p><a href="tel:0612345678"><img src="images/footerimages/mobiel.png" alt="Phone image">06 12345678</a></p>
                    </div>

                </div>
            <!-- Einde Footer Links -->
            </div>

            <!-- Copyright -->
            <div class="footer-copyright text-center py-3">
                &copy; <?=date("Y")?> Copyright: EenmaalAndermaal
            </div>
            <?php
            // Toast system
            $toast = isset($_GET['toast']) ? $_GET['toast'] : $toast; // check if toast is set in get
            $toast = isset($_POST['toast']) ? $_POST['toast'] : $toast; // check if toast is set in post
            if(isset($toast)) {
                $toastDuration = (isset($toastDuration)) ? $toastDuration : 5000;
                echo "<div id='snackbar' class='show'>$toast</div>";
                echo "<script type='text/javascript'>showToast($toastDuration);</script>";
            }
            ?>
        </footer>
    </body>
</html>