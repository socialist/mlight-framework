<?php

require dirname(__DIR__) . '/vendor/autoload.php';

Application\Bootstrap::app()->run(APP . 'config.php');