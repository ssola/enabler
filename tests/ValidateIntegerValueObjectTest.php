<?php
class ValidateIntegerValueObject extends PHPUnit_Framework_TestCase
{
	public function testCreateInteger()
	{
		$integer = new Enabler\Object\Integer(10);

		$this->assertEquals(10, $integer->getValue());
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testWrongValueForInteger()
	{
		$integer = new Enabler\Object\Integer(10.1);
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testWrongValueWithAnString()
	{
		$integer = new Enabler\Object\Integer("abcd");
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testPercentageIsEqualThanInteger()
	{
		$integer = new Enabler\Object\Integer(10);
		$percentage = new Enabler\Object\Percentage(
			new Enabler\Object\Integer(10)
		);

		$this->assertTrue($integer->equals($percentage));
	}	

	public function testIntegerIsEqualThanInteger()
	{
		$integer = new Enabler\Object\Integer(10);
		$secondInteger = new Enabler\Object\Integer(10);

		$this->assertTrue($integer->equals($secondInteger));
	}		
}