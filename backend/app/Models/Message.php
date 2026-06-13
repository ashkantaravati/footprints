<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Message extends Model { use HasFactory, SoftDeletes; protected $fillable=['circle_id','sender_user_id','body','retention_until']; protected $casts=['retention_until'=>'datetime']; public function circle(){return $this->belongsTo(Circle::class);} public function sender(){return $this->belongsTo(User::class,'sender_user_id');} public function attachments(){return $this->hasMany(Attachment::class);} }
