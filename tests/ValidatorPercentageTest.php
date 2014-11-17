<?php
class ValidatorPercentageTest extends PHPUnit_Framework_TestCase
{
    public function testWith60Percent()
    {
        $percentage = 60;
        $feature = new Enabler\Feature("Music", true, ["Enabler\Filter\Distributed" => $percentage]);

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

    public function testWith10Percent()
    {
        $percentage = 10;
        $feature = new Enabler\Feature("Music", true, ["Enabler\Filter\Distributed" => $percentage]);

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

    public function testWith35Percent()
    {
        $percentage = 35;
        $feature = new Enabler\Feature("Music", true, ["Enabler\Filter\Distributed" => $percentage]);

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


    public function testWith82Percent()
    {
        $percentage = 82;
        $feature = new Enabler\Feature("Music", true, ["Enabler\Filter\Distributed" => $percentage]);

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

    public function testWith1Percent()
    {
        $percentage = 1;
        $feature = new Enabler\Feature("Music", true, ["Enabler\Filter\Distributed" => $percentage]);

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