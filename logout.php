<?php
session_start();
/* doe iets met de sessie */
session_destroy();
// Redirect to the login page:
header('Location: index.php');
?>