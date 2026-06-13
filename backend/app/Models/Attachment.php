<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Attachment extends Model { use HasFactory, SoftDeletes; protected $fillable=['message_id','uploader_user_id','original_name','storage_path','bytes','mime_type','retention_until']; protected $casts=['retention_until'=>'datetime']; }
