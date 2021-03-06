<?php
/**
 * Created by PhpStorm.
 * User: alexlisenkov
 * Date: 7/31/17
 * Time: 7:23 PM
 */

namespace Createnl\Expires;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ExpiresScope implements Scope
{
    /**
     * All of the extensions to be added to the builder.
     *
     * @var array
     */
    protected $extensions = ['WithExpired', 'OnlyExpired'];

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $builder
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function apply(Builder $builder, Model $model) : void
    {
        $builder->where(
            $model->getQualifiedExpiresAtColumn(), '>', $model->freshTimestamp()
        )->orWhereNull($model->getQualifiedExpiresAtColumn());
    }

    /**
     * Extend the query builder with the needed functions.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    public function extend(Builder $builder) : void
    {
        foreach ($this->extensions as $extension) {
            $this->{"add{$extension}"}($builder);
        }
    }

    /**
     * Get the "expires at" column for the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return string
     */
    protected function getExpiresAtColumn(Builder $builder) : string
    {
        if (count($builder->getQuery()->joins) > 0) {
            return $builder->getModel()->getQualifiedExpiresAtColumn();
        }

        return $builder->getModel()->getExpiresAtColumn();
    }

    /**
     * Add the with-expired extension to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    protected function addWithExpired(Builder $builder) : void
    {
        $builder->macro('withExpired', function (Builder $builder) {
            return $builder->withoutGlobalScope($this);
        });
    }

    /**
     * Add the only-expired extension to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    protected function addOnlyExpired(Builder $builder) : void
    {
        $builder->macro('onlyExpired', function (Builder $builder) {
            $model = $builder->getModel();

            $builder->withoutGlobalScope($this)->where(
                $model->getQualifiedExpiresAtColumn(), '<=', $model->freshTimestamp()
            );

            return $builder;
        });
    }
}