<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = ['profile'];

    /**
     * Get the users in a profile.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
