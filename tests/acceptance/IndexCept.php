<?php

/**
 * @propery string $scenario
 */
$I = new AcceptanceTester($scenario);
$I->am('user');
$I->wantTo('This is Index File');

$I->amOnPage('/index/index');

$I->see('This is Index File');
