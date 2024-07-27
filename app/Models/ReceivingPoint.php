<?php

namespace App\Models;

use App\Models\UserInfo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class ReceivingPoint extends Model
{
    use HasFactory,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'open_time',
        'close_time',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        //
    ];

    // /**
    //  * Get  userInfo of users that they belong to the receiving Points
    //  * 
    //  * @return \Illuminate\Database\Eloquent\Relations\HasMany
    //  */
    // public function userInfos() {
    //     return $this->hasMany(UserInfo::class);
    // }
}
