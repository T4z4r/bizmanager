<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasRoles;

    protected $fillable = ['name','email','password'];
    protected $hidden = ['password','remember_token'];

    public function shops()
    {
        return $this->hasMany(Shop::class, 'owner_id');
    }

    public function shopkeeper()
    {
        return $this->hasOne(Shopkeeper::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class, 'created_by');
    }
}
