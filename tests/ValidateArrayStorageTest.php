<?php
class ValidateArrayStorageTest extends PHPUnit_Framework_TestCase
{
	public function testWithArrayStorage()
	{
		$feature = new Enabler\Feature(
			'secret-project', true, [
			'Enabler\Filter\Identifier' => [
					"userIds" => [
						1,2,3,4,5
					]
				]
			]
		);

		$identity = new Enabler\Identity(3);

		$enabler = new Enabler\Enabler(new Enabler\Storage\Memory(), $identity);

		$this->assertTrue($enabler->enabled('secret-project'));
	}
}