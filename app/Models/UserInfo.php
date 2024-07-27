<?php

namespace App\Models;

use App\Models\User;
use App\Models\Category;
use App\Models\ReceivingPoint;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class UserInfo extends Model
{
    use HasFactory,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'phone_number',
        'id_number',
        'address',
        'status',
        'age',
        'user_id',
        'category_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'category_id' => 'integer',
        'user_id' => 'integer',
    ];

    /**
     * get the user account that the userinfo belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo(User::class);
    }

    // /**
    //  *  get the receiving point that the user belongs to
    //  *
    //  * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    //  */
    // public function receivingPoint(){
    //     return $this->belongsTo(ReceivingPoint::class);
    // }

    /**
     *  get the Category that the user belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(){
        return $this->belongsTo(Category::class);
    }

    /**
     * boot that make the user_id is belong to auth user
     *
     * @return void
     */
    protected static function boot() {
        parent::boot();

        static::creating(function($userInfo){
            $userInfo->user_id = Auth::user()->id;
        });
    }
}
