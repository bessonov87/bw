<?php
use tests\codeception\frontend\AcceptanceTester;

/* @var $scenario Codeception\Scenario */

$I = new AcceptanceTester($scenario);
$I->wantTo('ensure that home page works');
$I->amOnPage(Yii::$app->homeUrl);
$I->see('<ul class="pagination">');
$I->seeLink('Гороскоп');
$I->click('Гороскоп');
$I->seeLink('Гороскопы на месяц');
