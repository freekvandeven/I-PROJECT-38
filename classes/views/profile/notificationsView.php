<main class="profielPagina">
    <div class="container">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-md-6 col-sm-6">
                    All new notifications
                    <ul>
                        <?php
                        $notifications = User::getNotifications($_SESSION['name']);
                            foreach($notifications as $notification){ // get all notifications of a user
                                echo "<li>$notification</li>"; // display notification
                            }
                        ?>
                    </ul>

                    <form method="post" action="">
                        <input type="hidden" name="token" value="<?=$token?>">
                        <input type="hidden" name="action" value="notifications">
                        <button type="submit" name="option" value="clear">Clear notifications</button>
                    </form>
                </div>
                <div class="col-xl-3 col-md-6 col-sm-6">
                    Select users from your history
                </div>
                <div class="col-xl-3 col-md-6 col-sm-6">
                    Chat with your fellow users
                </div>
            </div>
        </div>
    </div>
</main>