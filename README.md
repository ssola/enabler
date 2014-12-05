enabler [![Build Status](https://travis-ci.org/ssola/enabler.svg)](https://travis-ci.org/ssola/enabler) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/ssola/enabler/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/ssola/enabler/?branch=master) 
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

### How it works?

With Enabler is really simple to show/hide features to your users. Let me show how it works with this little example:


*Requirement:*
We need to deploy our new killer feature gradually. We expect a lot of new people using it and we need to be completely sure that it works properly. At this stage we only want to enable this feature to a really small set of customers: exactly 1% of them.


First of all we have to create our new Feature and include which filters should be used.

```php
$feature = new Enabler\Feature(
  'secret-feature',
  true,
  [
    'Enabler\Filter\Distributed' => [1]
  ]
);

$enabler = new Enabler\Enabler($storage);
$enabler->storage()->create($feature);

// At this point feature has been created and will use the Distributed filter to display it only to 1% of our visitors
// after this we can create the condition:

if ($enabler->enabled('secret-feature')) {
  // Here your feature for only 1% of your visitors.
}
```

Finally you determined to test your new Feature in a new scenario. In this respect we only want to reveal it to logged in customers.For that logic we have implemented the Identifier filter. You only have to instantiate an Identity object passing the required user data. In this case we must to pass the user id and group to which it belongs.

```php
$identity = new Enabler\Identity(MyUserClass::getUserId(), MyUserClass::getGroup());

$feature = new Enabler\Feature(
  'secret-feature',
  true,
  [
    'Enabler\Filter\Identifier' => ['groups' => ['early-adopters', 'test-users']]
  ]
);

$enabler = new Enabler\Enabler($storage, $identity);
$enabler->storage()->create($feature);

if ($enabler->enabled('secret-feature')) {
  // Here your feature for users that belongs to early-adopters or test-users group
}

```

But now imagine that we need to display only to a bigger amount (10%) of our test-users group in a particular date range. We can do it easily adding more than one filter to the feature filter chain, like this:

```php
$identity = new Enabler\Identity(MyUserClass::getUserId(), MyUserClass::getGroup());

$feature = new Enabler\Feature(
  'secret-feature',
  true,
  [
    'Enabler\Filter\Distributed' => [10],
    'Enabler\Filter\Identifier' => ['groups' => ['test-users']],
    'Enabler\Filter\Date' => ['from' => new DateTime('2014-10-30'), 'to' => new DateTime('2015-10-30')]
  ]
);

$enabler = new Enabler\Enabler($storage, $identity);
$enabler->storage()->create($feature);

if ($enabler->enabled('secret-feature')) {
  // Here your feature for users that belongs to early-adopters or test-users group
}

```

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

At the moment we support four different filters Random Weighted Distribution, IP, Date / Date Range and Identity. But we thought people will have great ideas and it's really simple to create your own filters.

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
- By Random weight distribution: You can display your feature for example only to 10% or your visitors
- By Identity: Use our Identity class or create your own in order to have access to User Id and/or Group.
- By date or date range: Display your feature depending on specific date or set a range to display it only for a precise range of dates.


[![Bitdeli Badge](https://d2weczhvl823v0.cloudfront.net/ssola/enabler/trend.png)](https://bitdeli.com/free "Bitdeli Badge")

