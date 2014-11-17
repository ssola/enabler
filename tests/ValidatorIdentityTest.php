<?php
class ValidatorIdentityTest extends PHPUnit_Framework_TestCase
{
    public function testWithWrongFeatureName()
    {
        $feature = new Enabler\Feature(
            "secret-project", true, [
                "Enabler\Filter\Identifier" => [
                    "userIds" => [
                        1, 2, 3, 10, 34, 54, 65, 24, 543, 564645, 23, 432, 54, 656
                    ]
                ]
            ]
        );

        $mockStorage = $this->getMockBuilder('Enabler\Storage\Storable')->getMock();
        $mockStorage->expects($this->any())
            ->method('get')
            ->will($this->returnValue($feature));

        $identity = new Enabler\Identity(10);
        $enabler = new Enabler\Enabler($mockStorage, $identity);
        $enabler->storage()->create($feature);

        $this->assertEquals(true, $enabler->enabled("secret-project-deleted"));     
    }

    public function testCheckByUserId()
    {
        $feature = new Enabler\Feature(
            "secret-project", true, [
                "Enabler\Filter\Identifier" => [
                    "userIds" => [
                        1, 2, 3, 10, 34, 54, 65, 24, 543, 564645, 23, 432, 54, 656
                    ]
                ]
            ]
        );

        $mockStorage = $this->getMockBuilder('Enabler\Storage\Storable')->getMock();
        $mockStorage->expects($this->any())
            ->method('get')
            ->will($this->returnValue($feature));

        $identity = new Enabler\Identity(10);
        $enabler = new Enabler\Enabler($mockStorage, $identity);
        $enabler->storage()->create($feature);

        $this->assertEquals(true, $enabler->enabled("secret-project"));

        $identity->setUserId(232332);
        $this->assertEquals(false, $enabler->enabled("secret-project"));        
    }

    public function testCheckByGroup()
    {
        $feature = new Enabler\Feature(
            "secret-project", true, [
                "Enabler\Filter\Identifier" => [
                    "groups" => [
                        "test", "early-adopters", "God"
                    ]
                ]
            ]
        );

        $mockStorage = $this->getMockBuilder('Enabler\Storage\Storable')->getMock();
        $mockStorage->expects($this->any())
            ->method('get')
            ->will($this->returnValue($feature));

        $identity = new Enabler\Identity(10, "early-adopters");
        $enabler = new Enabler\Enabler($mockStorage, $identity);
        $enabler->storage()->create($feature);

        $this->assertEquals(true, $enabler->enabled("secret-project"));

        $identity->setGroup("Nobody");
        $this->assertEquals(false, $enabler->enabled("secret-project"));        
    }    

    public function testMixingUserIdsAndGroups()
    {
        $feature = new Enabler\Feature(
            "secret-project", true, [
                "Enabler\Filter\Identifier" => [
                    "groups" => [
                        "test", "early-adopters", "God"
                    ]
                ],
                "Enabler\Filter\Identifier" => [
                    "userIds" => [
                        1, 2, 3, 10, 34, 54, 65, 24, 543, 564645, 23, 432, 54, 656
                    ]
                ]
            ]
        );

        $mockStorage = $this->getMockBuilder('Enabler\Storage\Storable')->getMock();
        $mockStorage->expects($this->any())
            ->method('get')
            ->will($this->returnValue($feature));

        $identity = new Enabler\Identity(10, "early-adopters");
        $enabler = new Enabler\Enabler($mockStorage, $identity);
        $enabler->storage()->create($feature);

        $this->assertEquals(true, $enabler->enabled("secret-project"));

        $identity->setUserId(13);
        $identity->setGroup("Nobody");
        $this->assertEquals(false, $enabler->enabled("secret-project"));    


        $identity->setUserId(24);
        $identity->setGroup("Nobody");
        $this->assertEquals(true, $enabler->enabled("secret-project"));          
    }
}