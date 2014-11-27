<?php namespace Enabler\Storage;

use Enabler\Feature;

/**
 * Store features in memory using an array
 * 
 * @package Enabler\Storage
 */
class Memory implements Storable
{
	/**
	 *  Stores features in this array
	 * 
	 * @var array
	 */
	private $data = [];

	public function __construct() 
	{
	}

	public function create (Feature $feature)
	{
		if(!isset($this->data[$feature->name])) {
			$this->data[$feature->name] = $feature;
		}

		return $feature;
	}

	public function delete (Feature $feature)
	{
		if(isset($this->data[$feature->name])) {
			unset($this->data[$feature->name]);
		}
	}

	public function get ($name)
	{
		if(!isset($this->data[$name])) {
			return false;
		}

		return $this->data[$name];
	}
}