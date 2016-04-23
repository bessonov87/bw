<?php
use tests\codeception\frontend\FunctionalTester;
use tests\codeception\frontend\_pages\ContactPage;

/* @var $scenario Codeception\Scenario */

$I = new FunctionalTester($scenario);
$I->wantTo('ensure that contact works');

$contactPage = ContactPage::openBy($I);

$I->see('Связь с администрацией', 'h1');

$I->amGoingTo('submit contact form with no data');
$contactPage->submit([]);
$I->expectTo('see validations errors');
$I->see('Связь с администрацией', 'h1');
$I->see('Поле не может быть пустым', '.help-block');
$I->see('Поле не может быть пустым', '.help-block');
$I->see('Поле не может быть пустым', '.help-block');
$I->see('Поле не может быть пустым', '.help-block');

$I->amGoingTo('submit contact form with not correct email');
$contactPage->submit([
    'name' => 'tester',
    'email' => 'tester.email',
    'subject' => 'test subject',
    'message' => 'test content'
]);
$I->expectTo('see that email adress is wrong');
$I->dontSee('Необходимо заполнить «Name».', '.help-block');
$I->see('Значение «Email» не является правильным email адресом.', '.help-block');
$I->dontSee('Необходимо заполнить «Subject».', '.help-block');
$I->dontSee('Необходимо заполнить «Body».', '.help-block');

$I->amGoingTo('submit contact form with correct data');
$contactPage->submit([
    'name' => 'tester',
    'email' => 'tester@example.com',
    'subject' => 'test subject',
    'message' => 'test content'
]);
$I->see('Спасибо за обращение.');
