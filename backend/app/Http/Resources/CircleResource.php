<?php
namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
class CircleResource extends JsonResource { public function toArray($request): array { return ['id'=>$this->id,'name'=>$this->name,'is_direct'=>(bool)$this->is_direct,'updated_at'=>$this->updated_at?->toISOString()]; } }
