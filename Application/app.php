<?php

define('APP', dirname(__FILE__) . '/');

function customAutoload($className) {
    $basePath = dirname(dirname(__FILE__));
  $path = '/' . str_replace('\\', DIRECTORY_SEPARATOR, $className).'.php';
  require_once($basePath . $path);
}
spl_autoload_register('customAutoload');