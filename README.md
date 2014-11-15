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

### How it works?

TBD

### Features

You can choose among different filters or create your owns in order to displar/hide your features:

- By IP: Display your feature only to certain IP or IP range (TBD)
- By distributed weight: You can display your feature for example only to 10% or your visitors
- By data: Define which value should match for certain variable, this is useful if you want to display your feature only to certain users / groups
