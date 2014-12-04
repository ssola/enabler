<?php namespace Enabler\Object;

interface ValueObjectInterface
{
	public function equals(ValueObjectInterface $object);
	public function getValue();
	public function __toString();
}