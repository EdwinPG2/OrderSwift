<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OwnerRelationshipScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        if (Auth::user()) {
            $owner = DB::table('users')
                ->where('id', '=', Auth::user()->id)
                ->select('owner_id')
                ->first()
                ->owner_id;
            $builder->where($model->getTable() . '.owner_id', '=', $owner);
        }
    }
}
