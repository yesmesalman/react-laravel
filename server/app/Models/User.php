<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Models\UserRole;
use Khsing\World\Models\Country;
use Khsing\World\Models\Division;
use Khsing\World\Models\City;
use App\Helpers\Media;
use App\Models\UserCard;
use App\Models\UserDetail;
use App\Models\Payment;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'status', 'role_id', 'country_id', 'state_id', 'city_id', 'zip_code', 'service_id', 'experience', 'otp', 'status', 'email', 'password', 'contact_mode', 'contact_number', 'profile_picture'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getUserDisplayFields()
    {
        return [
            "id" => $this->id,
            "first_name" => $this->first_name,
            "email" => $this->email,
            "last_name" => $this->last_name,
            "status" => $this->status,
            "role_id" => $this->role_id,
            "role" => $this->Role ? $this->Role->name : null,
            "country_id" => $this->country_id,
            "country" => $this->Country ? $this->Country->name : null,
            "state_id" => $this->state_id,
            "state" => $this->State ? $this->State->name : null,
            "city_id" => $this->city_id,
            "city" => $this->City ? $this->City->name : null,
            "zip_code" => $this->zip_code,
            "otp" => $this->otp,
            "contact_number" => $this->contact_number,
            "profile_picture" => Media::convertFullUrl($this->profile_picture),
            "created_at" => date('Y/m/d H:i:s', strtotime($this->created_at))
        ];
    }

    public function Role()
    {
        return $this->belongsTo(UserRole::class, 'role_id', 'id');
    }

    public function Country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function State()
    {
        return $this->belongsTo(Division::class, 'state_id', 'id');
    }

    public function City()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

    public function Cards()
    {
        return $this->hasMany(UserCard::class);
    }

    public function Payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function UserDetail()
    {
        return $this->hasOne(UserDetail::class);
    }

    public function getCreatedAtForHumans()
    {
        return Carbon::parse($this->created_at)->diffForHumans();
    }
}
