<?php namespace App\Tests;
use App\Tests\AcceptanceTester;

class UserCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    // tests
    public function userTest(AcceptanceTester $I)
    {
        $I->am('ROLE_USER');
        $I->amOnPage('/admin/home');
    }
}
