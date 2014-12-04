<?php namespace Enabler\Object;

use InvalidArgumentException;

class Integer implements ValueObjectInterface
{
	protected $value = null;

	public function __construct($value)
	{
		$validation = filter_var($value, FILTER_VALIDATE_INT);

		if ($validation === false) {
			throw new InvalidArgumentException("Value is not an integer");
		}

		$this->value = $value;
	}

	public function getValue()
	{
		return $this->value;
	}

	public function equals(ValueObjectInterface $object)
	{
		if (\get_class($this) !== \get_class($object)) {
			throw new InvalidArgumentException("Object is not an integer " . \get_class($object));
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