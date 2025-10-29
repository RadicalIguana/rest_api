<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organization extends Model
{
    protected $fillable = ['name', 'building_id'];

    public function building(): belongsTo
    {
        return $this->belongsTo(Building::class);
    }

    public function phones(): hasMany
    {
        return $this->hasMany(OrganizationPhone::class);
    }

    public function activities(): belongsToMany
    {
        return $this->belongsToMany(Activity::class, 'organization_activities');
    }
}
