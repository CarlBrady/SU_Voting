<?php 
class UserTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testUser()
    {
        $user = new \App\Entity\User;

        $user->setFirstName('Carl');
        $user->setLastName('Brady');
        $user->setUsername('Test');
        $user->setEmail('carl@carl.ie');
        $user->setCampus('Science');
        $user->setRoles(['ROLE_USER']);

        $this->assertEquals($user->getFirstName(), 'Carl');
        $this->assertEquals($user->getLastName(), 'Brady');
        $this->assertEquals($user->getUserName(), 'Test');
        $this->assertEquals($user->getEmail(), 'carl@carl.ie');
        $this->assertEquals($user->getCampus(), 'Science');
        $this->assertEquals($user->getRoles(), ['ROLE_USER']);
    }
}