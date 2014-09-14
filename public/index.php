<?php

include dirname(dirname(__FILE__)) . '/Application/app.php';

Application\Bootstrap::run()->init(APP . 'config.php');