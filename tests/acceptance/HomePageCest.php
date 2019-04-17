<?php namespace App\Tests;
use App\Tests\AcceptanceTester;

class HomePageCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    // tests
    public function homePageContent(AcceptanceTester $I) {
        $I->amOnPage('/');
        $I->see('Home');
        $I->seeLink('About');
        $I->click('Login');
        $I->see('Username');

    }

}
