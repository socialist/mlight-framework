<?php

include dirname(dirname(__FILE__)) . '/Application/Bootstrap.php';

Application\Bootstrap::app()->run(APP . 'config.php');