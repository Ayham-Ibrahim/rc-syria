<?php

namespace App\Models;

use App\Models\User;
use App\Models\ReceivingPoint;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class ReceivingSchedule extends Model
{
    use HasFactory,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'receiving_point_id',
        'receiving_time',
    ];

    protected $dates = [
        'receiving_time',
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
     * Get the user how own the receiving time
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the receivingPoint where the user will receive from
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function receivingPoint()
    {
        return $this->belongsTo(ReceivingPoint::class);
    }
}
