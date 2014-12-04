<?php
class ValidatePercentageValueObjectTest extends PHPUnit_Framework_TestCase
{
	public function testCreatePercentage()
	{
		$percentage = new Enabler\Object\Percentage(new Enabler\Object\Integer(10));

		$this->assertEquals(10, $percentage->getValue());
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testWrongValueForPercentage()
	{
		$percentage = new Enabler\Object\Percentage(new Enabler\Object\Integer(102));
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testWrongValueWithAnString()
	{
		$percentage = new Enabler\Object\Percentage(new Enabler\Object\Integer("abcd"));
	}

	public function testIntegerIsEqualThanInteger()
	{
		$integer = new Enabler\Object\Integer(10);
		$percentage = new Enabler\Object\Percentage(
			new Enabler\Object\Integer(10)
		);

		$this->assertTrue($percentage->equals($integer));
	}	
}