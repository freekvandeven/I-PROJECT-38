<?php
class Debug{
    static function dump($input){
        echo '<pre>' , var_dump($input) , '</pre>';
    }

    static function diePrint($input){
        die(print_r($input));
    }
}