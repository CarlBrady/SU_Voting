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
        // Arrange
        $num1 = 1;
        $num2 = 1; $expectedResult = 2;
// Act
        $result = $num1 + $num2;
// Assert
        $this->assertEquals($expectedResult, $result);

    }
}