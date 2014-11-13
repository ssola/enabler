<?php
class ValidatorPercentageTest extends PHPUnit_Framework_TestCase
{
    public function testCheckIpValidatorWorks()
    {
        $percentage = 30;
        $feature = new Enabler\Feature("Music", true, ["Enabler\Validator\Percentage" => $percentage]);

        $mockStorage = $this->getMockBuilder('Enabler\Storage\Storable')->getMock();
        $mockStorage->expects($this->any())
            ->method('get')
            ->will($this->returnValue($feature));

        $enabler = new Enabler\Enabler(
            $mockStorage
        );

        $enabler->storage()->create($feature);        
        $numEnables = 0;

        for($i = 0; $i <= 100; $i++) {
            if($enabler->enabled('Music')) {
                $numEnables++;
            }
        }

        $result = (($numEnables-($numEnables*.10)) <= $percentage) ? true : false;

        $this->assertTrue($result);
    }
}