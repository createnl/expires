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
$model->withExpired() : Builder;
 
// Get only expired records
$model->onlyExpired() : Builder;
 
// Update expiration date
$model->setExpiration(Carbon $date) : Model;
 
// Remove expiration date
$model->unExpire() : Model;
 
// Check if record is expired
$model->isExpired() : bool;
 
// Get carbon object of expiration date
$model->expiresAt() :? Carbon;
 
// Extend expiration by defined interval
$model->extendExpiration() : Model;
 
// Disable automatic setting of expiration date
Model::disableExpiring() : void;
 
// Enable automatic setting of expiration date
Model::enableExpiring() : void;

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

[ico-version]: https://img.shields.io/packagist/v/createnl/expires.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/createnl/expires/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/createnl/expires.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/createnl/expires.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/createnl/expires.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/createnl/expires
[link-travis]: https://travis-ci.org/createnl/expires
[link-scrutinizer]: https://scrutinizer-ci.com/g/createnl/expires/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/createnl/expires
[link-downloads]: https://packagist.org/packages/createnl/expires
[link-author]: https://github.com/alexlisenkov
[link-contributors]: ../../contributors
