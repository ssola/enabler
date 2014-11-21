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
     * @param Feature $feature
     * @return void
     */
    public function create(Feature $feature);

    /**
     * Given a Feature name should be possible to delete from persistence
     * 
     * @param Feature $feature
     * @return void
     */
    public function delete(Feature $feature);

    /**
     * Given a Feature name grab it from persistence
     * 
     * @param string $name
     * @return Feature
     */
    public function get($name);
}