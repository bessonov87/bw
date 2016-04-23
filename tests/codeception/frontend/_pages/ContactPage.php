<?php

namespace tests\codeception\frontend\_pages;

use yii\codeception\BasePage;

/**
 * Represents contact page
 * @property \codeception_frontend\AcceptanceTester|\codeception_frontend\FunctionalTester $actor
 */
class ContactPage extends BasePage
{
    public $route = 'site/feedback';

    /**
     * @param array $contactData
     */
    public function submit(array $contactData)
    {
        foreach ($contactData as $field => $value) {
            $inputType = $field === 'message' ? 'textarea' : 'input';
            $this->actor->fillField($inputType . '[name="Contact2Form[' . $field . ']"]', $value);
        }
        $this->actor->click('Отправить');
    }
}
