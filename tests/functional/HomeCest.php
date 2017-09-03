<?php

namespace app\tests\functional;

use FunctionalTester;

class HomeCest
{
    public function checkOpen(FunctionalTester $I)
    {
        $I->amOnPage(\Yii::$app->homeUrl);
        $I->see(\Yii::$app->name);
        $I->seeLink('About');
        $I->click('About');
        $I->see('This is the About page.');
    }
}