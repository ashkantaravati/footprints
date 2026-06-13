<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Setting extends Model { public $incrementing=false; protected $primaryKey='key'; protected $keyType='string'; protected $fillable=['key','value']; public static function value(string $key, mixed $default=null): mixed { return static::query()->whereKey($key)->value('value') ?? $default; } }
