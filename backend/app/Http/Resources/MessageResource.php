<?php
namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
class MessageResource extends JsonResource { public function toArray($request): array { return ['id'=>$this->id,'circle_id'=>$this->circle_id,'body'=>$this->body,'sender'=>new UserResource($this->whenLoaded('sender')),'created_at'=>$this->created_at?->toISOString()]; } }
