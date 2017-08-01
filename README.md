# tickets

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]


This is where your description should go. Try and limit it to a paragraph or two, and maybe throw in a mention of what
PSRs you support to avoid any confusion with users and contributors.


## Install

### Via BitBucket

Add to composer.json:

``` json
"repositories": [ { "type": "git", "url": "git@git001.create.nl:packages/Expires.git" } ],
```


Add to composer.json require array
``` json
 "createnl/expires": "master@dev"
```


### Via Composer

``` bash
$ composer require createnl/expires
```

## Usage

### Starting an order / getting existing order

``` php

class Model extends Eloquent
{
    use Createnl\Expires\Expirable
    
    /**
     * Indicates if the model should set an auto expire
     *
     * @var bool
     */
    protected static $autoExpire = true;
     
    /**
     * Indicates if the model should reset the expiration date on model update
     *
     * @var bool
     */
    protected static $autoExtend = true;
    
    /**
     * The amount of interval to be added to the
     * Please see ISO_8601 durations for correct markups
     *
     * @var string (\DateInterval)
     */
    protected static $autoExpireDate = 'P5Y';
}
```


## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email alex@create.nl instead of using the issue tracker.

## Credits

- [Alex Lisenkov][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/createnl/tickets.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/createnl/tickets/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/createnl/tickets.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/createnl/tickets.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/createnl/tickets.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/createnl/tickets
[link-travis]: https://travis-ci.org/createnl/tickets
[link-scrutinizer]: https://scrutinizer-ci.com/g/createnl/tickets/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/createnl/tickets
[link-downloads]: https://packagist.org/packages/createnl/tickets
[link-author]: https://github.com/:SpecialistAlex
[link-contributors]: ../../contributors
