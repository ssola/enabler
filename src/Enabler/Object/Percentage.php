<?php namespace Enabler\Object;

use InvalidArgumentException;

class Percentage implements ValueObjectInterface
{
	const MIN_VALUE = 0;
	const MAX_VALUE = 100;
	protected $value;

	public function __construct(Integer $object)
	{
		if ($object->getValue() >= self::MIN_VALUE && $object->getValue() <= self::MAX_VALUE) {
			return $this->value = $object->getValue();
		}

		throw new InvalidArgumentException("Value is not a proper percentage");
	}

	public function getValue()
	{
		return $this->value;
	}

	public function equals(ValueObjectInterface $object)
	{
		if (\get_class(new Integer($this->value)) !== \get_class($object)) {
			throw new InvalidArgumentException("Object is not a percentage");
		}	

		if ($object->getValue() === $this->getValue()) {
			return true;
		}

		return false;
	}

	public function __toString()
	{
		return sprintf("%d", $this->value);
	}	
}