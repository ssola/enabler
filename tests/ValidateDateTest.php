<?php
class ValidateDateTest extends PHPUnit_Framework_TestCase
{
   public function testWithCurrentDate()
{
        $feature = new Enabler\Feature(
            "secret-project", true, [
                "Enabler\Filter\Date" => [new DateTime()]
            ]
        );

        $mockStorage = $this->getMockBuilder('Enabler\Storage\Storable')->getMock();
        $mockStorage->expects($this->any())
            ->method('get')
            ->will($this->returnValue($feature));

        $identity = new Enabler\Identity(10);

        $enabler = new Enabler\Enabler(
            $mockStorage, $identity
        );

        $enabler->storage()->create($feature);     

        $this->assertTrue($enabler->enabled('secret-project'));
    }

    public function testWithDateFromThePast()
    {
        $feature = new Enabler\Feature(
            "secret-project", true, [
                "Enabler\Filter\Date" => [new DateTime("2013-10-01")]
            ]
        );

        $mockStorage = $this->getMockBuilder('Enabler\Storage\Storable')->getMock();
        $mockStorage->expects($this->any())
            ->method('get')
            ->will($this->returnValue($feature));

        $identity = new Enabler\Identity(10);

        $enabler = new Enabler\Enabler(
            $mockStorage, $identity
        );

        $enabler->storage()->create($feature);     

        $this->assertTrue($enabler->enabled('secret-project'));
    }    

    public function testWithDateFromTheFuture()
    {
        $feature = new Enabler\Feature(
            "secret-project", true, [
                "Enabler\Filter\Date" => [new DateTime("2040-10-01")]
            ]
        );

        $mockStorage = $this->getMockBuilder('Enabler\Storage\Storable')->getMock();
        $mockStorage->expects($this->any())
            ->method('get')
            ->will($this->returnValue($feature));

        $identity = new Enabler\Identity(10);

        $enabler = new Enabler\Enabler(
            $mockStorage, $identity
        );

        $enabler->storage()->create($feature);     

        $this->assertFalse($enabler->enabled('secret-project'));
    }    

    public function testWithValidRange()
    {
        $feature = new Enabler\Feature(
            "secret-project", true, [
                "Enabler\Filter\Date" => ["from" => new DateTime("2000-10-01"), "to" => new DateTime("2040-10-01")]
            ]
        );

        $mockStorage = $this->getMockBuilder('Enabler\Storage\Storable')->getMock();
        $mockStorage->expects($this->any())
            ->method('get')
            ->will($this->returnValue($feature));

        $identity = new Enabler\Identity(10);

        $enabler = new Enabler\Enabler(
            $mockStorage, $identity
        );

        $enabler->storage()->create($feature);     

        $this->assertTrue($enabler->enabled('secret-project'));
    }    

    public function testWithWrongRange()
    {
        $feature = new Enabler\Feature(
            "secret-project", true, [
                "Enabler\Filter\Date" => ["from" => new DateTime("2000-10-01"), "to" => new DateTime("2001-10-01")]
            ]
        );

        $mockStorage = $this->getMockBuilder('Enabler\Storage\Storable')->getMock();
        $mockStorage->expects($this->any())
            ->method('get')
            ->will($this->returnValue($feature));

        $identity = new Enabler\Identity(10);

        $enabler = new Enabler\Enabler(
            $mockStorage, $identity
        );

        $enabler->storage()->create($feature);     

        $this->assertFalse($enabler->enabled('secret-project'));
    } 
}