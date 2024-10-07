<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\OwnerAssignObserver;
use App\Scopes\OwnerRelationshipScope;

class Branch extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();
        static::observe(new OwnerAssignObserver());
        static::addGlobalScope(new OwnerRelationshipScope);
    }

    public function owner()
    {
        return $this->belongsTo(Owner::class, 'owner_id', 'id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'branch_user', 'branch_id', 'user_id');
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}
