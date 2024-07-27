<?php

namespace App\Models;

use App\Models\UserInfo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Category extends Model
{
    use HasFactory,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        //
    ];

    /**
     * Get  user's information that they belong to the category
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userInfos() {
        return $this->hasMany(UserInfo::class);
    }
}
