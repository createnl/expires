<?php
/**
 * Created by PhpStorm.
 * User: alexlisenkov
 * Date: 7/31/17
 * Time: 7:24 PM
 */

namespace Createnl\Expires;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

trait Expireable
{
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

    /**
     * Boot the expireable trait for a model.
     *
     * @return void
     */
    public static function bootExpireAble() : void
    {
        static::addGlobalScope(new ExpiresScope());

        self::creating(function (Model $model) {
            if( self::$autoExpire )
                $model->{$model->getQualifiedExpiresAtColumn()} = $model->expirationDate();
        });
        self::updating(function (Model $model) {
            if( self::$autoExtend && self::$autoExpire )
                $model->{$model->getQualifiedExpiresAtColumn()} = $model->expirationDate();
        });
    }

    /**
     * Get Carbon object of parsed expiration date.
     *
     * @return Carbon
     */
    public function expirationDate() : Carbon
    {
        $interval = new \DateInterval(self::$autoExpireDate);
        return $this->freshTimestamp()->add($interval);
    }

    /**
     * Get the name of the "expires at" column.
     *
     * @return string
     */
    public function getExpiresAtColumn() : string
    {
        return defined('static::EXPIRES_AT') ? static::EXPIRES_AT : 'expires_at';
    }

    /**
     * Get the fully qualified "expires at" column.
     *
     * @return string
     */
    public function getQualifiedExpiresAtColumn() : string
    {
        return $this->getTable().'.'.$this->getExpiresAtColumn();
    }

    /**
     * Extend the expiration date.
     *
     * @return bool
     */
    public function extendExpiration() : bool
    {
        return $this->update([$this->getExpiresAtColumn() => $this->expirationDate()]);
    }

    /**
     * Unset expiration date.
     *
     * @return bool
     */
    public function unExpire() : bool
    {
        self::disableExpiring();
        $this->{$this->getExpiresAtColumn()} = null;
        $success = $this->save();
        self::enableExpiring();
        return $success;
    }

    /**
     * Disable expiring.
     */
    public static function disableExpiring() : void
    {
        self::$autoExpire = false;
    }

    /**
     * Enable expiring.
     */
    public static function enableExpiring() : void
    {
        self::$autoExpire = true;
    }

}