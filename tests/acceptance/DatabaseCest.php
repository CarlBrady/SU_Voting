<?php namespace App\Tests;
use App\Tests\AcceptanceTester;

class DatabaseCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    // tests
    public function testUsersInDb(AcceptanceTester $I) {
    $I->seeInRepository('App\Entity\User', [ 'username' => 'user'
    ]); $I->seeInRepository('App\Entity\User', [
        'username' => 'admin'
    ]);
    $I->seeInRepository('App\Entity\User', [ 'username' => 'matt'
    ]);
}
}
