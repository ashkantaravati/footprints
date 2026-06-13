<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = ['username','password','is_admin','disabled_at'];
    protected $hidden = ['password','remember_token'];
    protected $casts = ['password'=>'hashed','is_admin'=>'boolean','disabled_at'=>'datetime'];
    public function groups(){ return $this->belongsToMany(Circle::class, 'circle_members')->withPivot('role')->withTimestamps(); }
}
