<?php
session_start();
require_once('includes/functions.php');


$title = 'test page';

require_once('includes/header.php');


function removeBadElements($input)
{ // remove all bad characters
    preg_replace('/(<script[^>]*>.+?<\/script>|<style[^>]*>.+?<\/style>)/s', '', $input);
    $doc = new DOMDocument();
    $doc->loadHTML($input);

    //removeElementsByTagName('script', $doc);
    $input = strip_tags($input, '<p><a><h1><h2><h3><h4><h5><br><b><i>');
    return $input;
}



function calculateCurrency($amount, $currency)
{
    $multiplier = 1.0;
    if ($currency == 'USD') {
        $multiplier = 0.92;
    } else if ($currency == 'GBP') {
        $multiplier = 1.14;
    }
    return $amount * $multiplier;
}





//echo calculateDistance(calculateLocation('6671GK'),calculateLocation('6525EC'));
//echo generateCategoryDropdown();
require_once('includes/footer.php');
?>