<?php

namespace tests\codeception\frontend\functional;

use tests\codeception\frontend\_pages\SignupPage;
use common\models\ar\User;

class SignupCest
{

    /**
     * This method is called before each cest class test method
     * @param \Codeception\Event\TestEvent $event
     */
    public function _before($event)
    {
    }

    /**
     * This method is called after each cest class test method, even if test failed.
     * @param \Codeception\Event\TestEvent $event
     */
    public function _after($event)
    {
        User::deleteAll([
            'email' => 'tester.email@example.com',
            'username' => 'tester',
        ]);
    }

    /**
     * This method is called when test fails.
     * @param \Codeception\Event\FailEvent $event
     */
    public function _fail($event)
    {

    }

    /**
     *
     * @param \codeception_frontend\FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     */
    public function testUserSignup($I, $scenario)
    {
        $I->wantTo('ensure that signup works');

        $signupPage = SignupPage::openBy($I);
        $I->see('Регистрация', 'h1');
        $I->see('Пожалуйста заполните все поля формы:');

        $I->amGoingTo('submit signup form with no data');

        $signupPage->submit([]);

        $I->expectTo('see validation errors');
        $I->see('Необходимо заполнить «Логин».', '.help-block');
        $I->see('Необходимо заполнить «Email».', '.help-block');
        $I->see('Необходимо заполнить «Пароль».', '.help-block');

        $I->amGoingTo('submit signup form with not correct email');
        $signupPage->submit([
            'username' => 'tester',
            'email' => 'tester.email',
            'password' => 'tester_password',
        ]);

        $I->expectTo('see that email address is wrong');
        $I->dontSee('Необходимо заполнить «Логин».', '.help-block');
        $I->dontSee('Необходимо заполнить «Пароль».', '.help-block');
        $I->see('Значение «Email» не является правильным email адресом.', '.help-block');

        $I->amGoingTo('submit signup form with correct email');
        /*$signupPage->submit([
            'username' => 'tester',
            'email' => 'tester.email@example.com',
            'password' => 'tester_password',
            'passwordRepeat' => 'tester_password',
            'captcha' => 'testme',
        ]);
        $I->dontSee('The verification code is incorrect.', '.help-block');*/

        $I->expectTo('see that user is created');
        $I->seeRecord('common\models\ar\User', [
            'username' => 'tester',
            'email' => 'tester.email@example.com',
        ]);

        $I->expectTo('see that user logged in');
        $I->seeLink('Выход (tester)');
    }
}
