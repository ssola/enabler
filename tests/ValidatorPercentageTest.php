<?php
class ValidatorPercentageTest extends PHPUnit_Framework_TestCase
{
    public function testCheckIpValidatorWorks()
    {
        $percentage = 60;
        $feature = new Enabler\Feature("Music", true, ["Enabler\Filter\Percentage" => $percentage]);

        $mockStorage = $this->getMockBuilder('Enabler\Storage\Storable')->getMock();
        $mockStorage->expects($this->any())
            ->method('get')
            ->will($this->returnValue($feature));

        $enabler = new Enabler\Enabler(
            $mockStorage
        );

        $enabler->storage()->create($feature);        
        $numEnables = 0;

        for($i = 0; $i <= 10000; $i++) {
            if($enabler->enabled('Music')) {
                $numEnables++;
            }
        }

        $result = (($numEnables-($numEnables)) <= $percentage) ? true : false;

        $this->assertTrue($result);
    }
}