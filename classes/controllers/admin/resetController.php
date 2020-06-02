<?php

# this controller file gets run when the admin wants to reset the page

setupDatabase();
$toast = 'database reset succesvol voltooid';
$_GET['category'] = $_POST['category'];