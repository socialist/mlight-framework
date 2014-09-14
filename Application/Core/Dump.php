<?php
namespace Application\Core;
/**
 * Description of Dump
 *
 * @author walk
 */
class Dump {
    
    public static function log($data)
    {
        echo "<pre>\n";
        var_dump($data);
        echo "</pre>\n";
    }
    
    public static function printLog($data)
    {
        echo "<pre>\n";
        print_r($data);
        echo "</pre>\n";
    }
}
