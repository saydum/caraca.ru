<?php

namespace App\Http\Requests;

use App\Enums\AdStatus;
use App\Enums\City;
use App\Enums\ModerationAdStatus;
use App\Enums\TypeCall;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class AdRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'price' => 'nullable|numeric|min:0',
//            'brand' => 'required|string|max:255',
//            'model' => 'required|string|max:255',
            'year' => 'nullable|integer|min:1900|max:'.date('Y'),
            'description' => 'nullable|string',
            'images'   => 'nullable|array|max:6',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:10240',
            'status' => [new Enum(AdStatus::class)],
            'moderation_status' => [new Enum(ModerationAdStatus::class)],
            'address' => 'nullable|string|max:255',
            'city' => ['required', new Enum(City::class)],
            'phone' => 'required|string|max:20',
            'type_call' => ['required', new Enum(TypeCall::class)],
        ];
    }
}
