<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $fillable = ['name','location','owner_id'];

    public function owner(){ return $this->belongsTo(User::class,'owner_id'); }
    public function shopkeepers(){ return $this->hasMany(Shopkeeper::class); }
    public function products(){ return $this->hasMany(Product::class); }
    public function sales(){ return $this->hasMany(Sale::class); }
}
