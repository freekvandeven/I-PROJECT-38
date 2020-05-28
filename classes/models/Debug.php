<?php
class Debug{
    static function dump($input,$msg = null){
        echo "$msg";
        echo '<pre>' , var_dump($input) , '</pre>';
    }

    static function diePrint($input){
        die(Debug::dump($input));
    }
}