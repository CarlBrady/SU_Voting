<?php namespace App\Tests;
use App\Tests\AcceptanceTester;

class AdminCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    // tests
    public function adminTest(AcceptanceTester $I)
    {
        $I->am('ROLE_AMIN');
        $I->amOnPage('/student');
    }
}
