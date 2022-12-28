<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //fungsi yang dijalankan ketika model dibuat
    protected static function boot()
    {
        //menjalankan fungsi yang ada di authenticable
        parent::boot();

        //mendefiniskan fungsi ketika data akan disave ke database
        static::creating(function($user){
            //hashing password
            $hash = Hash::make($user->password);
            //set password to be hash
            $user->password = $hash;
        });

        //mendefisniskan fungsi ketika data akan diupdate
        self::updating(function($user){
            //check if password is updated?
            if($user->isDirty(["password"])){
                //hashing password
                $hash = Hash::make($user->password);
                // set password to be hash
                $user->password = $hash;
            }
        });
    }
}
