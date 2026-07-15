<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    protected $fillable = [
        'name',
        'email',
        'university',
        'career',
        'photo',
    ];

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }
}
