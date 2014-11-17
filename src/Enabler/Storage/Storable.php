<?php namespace Enabler\Storage;

use Enabler\Feature;

/**
 * This interface describes the minimal features should have your
 * persistence adapter.
 * 
 * @pacakge Enabler\Storage
 */
interface Storable
{
    /**
     * Given a Feature should be possible to store it
     * 
     * @param Enabler\Feature $feature
     */
    public function create(Feature $feature);

    /**
     * Given a Feature name should be possible to delete from persistence
     */
    public function delete();

    /**
     * Given a Feature name grab it from persistence
     * 
     * @param string $name
     */
    public function get($name);
}