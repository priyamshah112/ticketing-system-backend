<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Str;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'userType'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function userRole(){
        return $this->hasOne('App\Models\Role', 'id', 'role_id');
    }

    public static function generatePassword()
    {
      // Generate random string and encrypt it.
      return bcrypt(Str::random(35));
    }
    public static function getToken($user)
    {
      // Generate a new reset password token
      $token = Str::random(50);
      DB::select("INSERT INTO `password_resets`(`email`, `token`) VALUES ('$user->email', '$token')");
      // app('auth.password.broker')->createToken($user);
      return $token;

    }

    public function inventories(){
        return $this->hasMany('App\Models\Inventory', 'assigned_to', 'id');
    }


    public function softwares(){
        return $this->hasMany('App\Models\Software', 'assigned_to', 'id');
    }

    public function customerDetails(){
        return $this->hasOne('App\Models\CustomerDetails', 'user_id', 'id');
    }

    public function userDetails(){
        return $this->hasOne('App\Models\CustomerDetails', 'user_id', 'id');
    }
}
