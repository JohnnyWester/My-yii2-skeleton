<?php
namespace app\tests\api;

use ApiTester;
use app\tests\fixtures\UserFixture;

class SampleApiCest
{
    public function _before(ApiTester $I)
    {
        $I->haveFixtures([
            'user' => [
                'class' => UserFixture::className(),
            ]
        ]);

    }

    public function firstSample(ApiTester $I)
    {
        $I->wantTo('Get data via API');
        $I->amBearerAuthenticated('admin-token');
        $I->sendGET('v1/sample', ['id' => 100]);
        $I->seeResponseIsJson();
        $I->seeResponseContains('{"user":"admin"}');
    }

}//SampleApiCest