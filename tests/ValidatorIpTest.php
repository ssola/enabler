<?php
class ValidatorIpTest extends PHPUnit_Framework_TestCase
{
    public function testCheckIpValidatorWorks()
    {
        $feature = new Enabler\Feature("Music", true, ["Enabler\Filter\Ip" => ["127.0.2.1"]]);

        $mockStorage = $this->getMockBuilder('Enabler\Storage\Storable')->getMock();
        $mockStorage->expects($this->any())
            ->method('get')
            ->will($this->returnValue($feature));

        $enabler = new Enabler\Enabler(
            $mockStorage
        );

        $enabler->storage()->create($feature);
        
        $_SERVER['REMOTE_ADDR'] = "127.0.2.2";
        $this->assertEquals(false, $enabler->enabled('Music'));

        $_SERVER['REMOTE_ADDR'] = "127.0.2.1";
        $this->assertEquals(true, $enabler->enabled('Music'));
    }

    public function testCheckArrayOfIpsWorks()
    {
        $feature = new Enabler\Feature("Music", true, ["Enabler\Filter\Ip" => array("127.0.2.1", "192.23.12.10")]);

        $mockStorage = $this->getMockBuilder('Enabler\Storage\Storable')->getMock();
        $mockStorage->expects($this->any())
            ->method('get')
            ->will($this->returnValue($feature));

        $enabler = new Enabler\Enabler(
            $mockStorage
        );

        $enabler->storage()->create($feature);
        
        $_SERVER['REMOTE_ADDR'] = "127.0.2.2";
        $this->assertEquals(false, $enabler->enabled('Music'));

        $_SERVER['REMOTE_ADDR'] = "192.23.12.10";
        $this->assertEquals(true, $enabler->enabled('Music'));

        $_SERVER['REMOTE_ADDR'] = "127.0.2.1";
        $this->assertEquals(true, $enabler->enabled('Music'));
    }  

    /**
     * @expectedException InvalidArgumentException
     */
    public function testWithWrongInput()
    {
        $feature = new Enabler\Feature("Music", true, ["Enabler\Filter\Ips" => array("127.0.2.1", "192.23.12.10")]);
    }  
}