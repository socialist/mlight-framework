<?php

include dirname(dirname(__FILE__)) . '/Application/Bootstrap.php';

Application\Bootstrap::run()->init(APP . 'config.php');