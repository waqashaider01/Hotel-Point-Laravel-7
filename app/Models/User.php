<?php

namespace App\Models;

use App\Mail\PasswordReset;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use function Symfony\Component\Translation\t;

class User extends Authenticatable  implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'created_by_id',
        'first_name',
        'last_name',
        'role',
        'country_id',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['name'];

    public function sendPasswordResetNotification($token)
    {
        $url = route('password.reset', ['token' => $token]) . '?email=' . $this->email;
        $user_name = $this->name;
//        return new PasswordReset($url,$user_name);
        Mail::to($this)->send(new PasswordReset($url,$user_name));
    }

    public function getNameAttribute(){
        return $this->first_name . ' ' . $this->last_name;
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function created_users()
    {
        return $this->hasMany(User::class, 'created_by_id', 'id');
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id', 'id');
    }

    public function isAdmin()
    {
        return $this->role == 'Administrator';
    }

    public function hotels()
    {
        return $this->hasMany(HotelSetting::class, 'created_by_id', 'id');
    }

    public function connected_hotels()
    {
        return $this->belongsToMany(HotelSetting::class, 'hotel_settings_users', 'user_id', 'hotel_settings_id');
    }

}
