enabler [![Build Status](https://travis-ci.org/ssola/enabler.svg)](https://travis-ci.org/ssola/enabler)
=======

Enabler is a simple feature flag package. With this package you can display/hide your awesome new features to customers in order to deploy your new stuff smoothly and to have everything under control.

### Requirements

To use this package you only need to have:

- PHP >= 5.4
- Redis (it's our default persistence tool)
- Composer

If you need a different persistence tool like Memcache or MySQL you can simply write your own Storable adapter.

### Installation

composer require ssola/enabler
composer update

### Extend me

#### Storage

We need a storage adapter to be able to store your Feature configuration in some place. Our default storage tool is Redis, but if feel free to write your own adapters.

It's as simples as this:

```php
class MyAwesomeStorageAdapter implements Enabler\Storage\Storable
{
  public function create (Feature $feature) {
    // do your magic here!
  }
  
  public function delete ($name) {
    // delete a specific Feature
  }
  
  public function get ($name) {
    return $myFeature;
  }
}
```
#### Filters

At the moment we support three different filters Random Weighted Distribution, IP and Identity. But we thought people will have great ideas and it's really simple to create your own filters.

```php
class FilterByWeather implements Enabler\Filter\Filterable
{
  public function filter ($value, Feature $feature, Identity $identity) {
    // our value is Sunny
    $currentWeather = Weather::getFromIp(IP::getIp());
    
    if($currentWeather == $value) {
      return true;
    }
    
    return false;
  }
}
```

### Features

You can choose among different filters or create your owns in order to displar/hide your features:

- By IP: Display your feature only to certain IP or IP range (TBD)
- By distributed weight: You can display your feature for example only to 10% or your visitors
- By Identity: Use our Identity class or create your own in order to have access to User Id and/or Group.
