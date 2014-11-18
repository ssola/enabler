<?php
class ValidateComplexScenariosTest extends PHPUnit_Framework_TestCase
{
    public function testWithDistributedAndIdentity()
    {
        $percentage = 10;
        
        $feature = new Enabler\Feature(
            "secret-project", true, [
                "Enabler\Filter\Identifier" => [
                    "userIds" => [
                        1, 2, 3, 10, 34, 54, 65, 24, 543, 564645, 23, 432, 54, 656
                    ]
                ],
                "Enabler\Filter\Distributed" => [$percentage]
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
    
        $numEnables = 0;
        for($i = 0; $i <= 10000; $i++) {
            if($enabler->enabled('secret-project')) {
                $numEnables++;
            }
        }

        $result = (($numEnables-($numEnables)) <= $percentage) ? true : false;

        $this->assertTrue($result);
    }
}