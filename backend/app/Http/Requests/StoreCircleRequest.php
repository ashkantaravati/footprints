<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class StoreCircleRequest extends FormRequest { public function rules(): array { return ['name'=>['required','string','max:120'], 'member_ids'=>['array'], 'member_ids.*'=>['integer','exists:users,id']]; } }
