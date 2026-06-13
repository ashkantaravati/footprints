<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller; use App\Models\Footprint; use Illuminate\Http\JsonResponse; use Illuminate\Http\Request;
class PollController extends Controller { public function __invoke(Request $request): JsonResponse { $circleIds=$request->user()->groups()->pluck('circles.id'); $items=Footprint::whereIn('circle_id',$circleIds)->where('id','>',(int)$request->query('after_id',0))->orderBy('id')->limit(100)->get(); return response()->json(['data'=>$items,'poll_interval_seconds'=>config('footprints.poll_interval')]); } }
