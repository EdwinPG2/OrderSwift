<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\OwnerAssignObserver;
use App\Scopes\OwnerRelationshipScope;

class Room extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'active', 'owner_id', 'branch_id'];

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

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
