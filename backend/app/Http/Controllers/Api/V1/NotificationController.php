<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller; use App\Models\Notification; use Illuminate\Http\JsonResponse; use Illuminate\Http\Request;
class NotificationController extends Controller { public function index(Request $request): JsonResponse { return response()->json(['data'=>Notification::whereBelongsTo($request->user())->latest()->limit(50)->get()]); } public function markRead(Notification $notification): JsonResponse { abort_unless($notification->user_id===request()->user()->id,403); $notification->update(['read_at'=>now()]); return response()->json(['ok'=>true]); } }
