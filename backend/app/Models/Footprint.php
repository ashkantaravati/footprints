<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Footprint extends Model { use HasFactory; public $timestamps=false; protected $fillable=['type','actor_user_id','circle_id','payload','created_at']; protected $casts=['payload'=>'array','created_at'=>'datetime']; public static function record(string $type, User $actor, ?Circle $circle=null, array $payload=[]): self { return self::create(['type'=>$type,'actor_user_id'=>$actor->id,'circle_id'=>$circle?->id,'payload'=>$payload,'created_at'=>now()]); } }
