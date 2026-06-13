<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Circle extends Model { use HasFactory, SoftDeletes; protected $fillable=['name','created_by_user_id','is_direct']; protected $casts=['is_direct'=>'boolean']; public function members(){return $this->belongsToMany(User::class,'circle_members')->withPivot('role')->withTimestamps();} public function messages(){return $this->hasMany(Message::class);} public function retentionPolicy(){return $this->hasOne(RetentionPolicy::class);} }
