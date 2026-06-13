<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class RetentionPolicy extends Model { protected $fillable=['circle_id','message_retention_days','attachment_retention_days']; }
