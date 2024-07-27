<?php

namespace App\Models;

use App\Models\UserInfo;
use App\Models\ReceivingSchedule;
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

    /**
     * Get  receivingSchedules of users that they belong to the receiving Point
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function receivingSchedules()
    {
        return $this->hasMany(ReceivingSchedule::class);
    }
}
