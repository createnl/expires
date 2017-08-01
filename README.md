# Expires

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

A package to add expiration date to database records.

## Install

### Via Composer

``` bash
$ composer require createnl/expires
```

## Usage

### Your migration
``` php

$table->dateTime('expires_at')->nullable()->default(null);

```

### Your model

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

### Methods

``` php

// Get records with expired
$model->withExpired();
 
// Get only expired records
$model->onlyExpired();
 
// Remove expiration date
$model->unExpire();
 
// Extend expiration
$model->extendExpiration();
 
// Disable automatic setting of expiration date
Model::disableExpiring();
 
// Enable automatic setting of expiration date
Model::enableExpiring();

```

### Custom expiration date logic

``` php

/**
 * @override
 * Get Carbon object of parsed expiration date.
 *
 * @return Carbon
 */
public function expirationDate() : Carbon
{
    // @todo: Manipulate expiration date
    $interval = new \DateInterval(self::$autoExpireDate);
    return $this->freshTimestamp()->add($interval);
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
