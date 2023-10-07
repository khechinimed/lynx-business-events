<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|max:255',
            'timestamp' => 'required|date_format:Y-m-d H:i:s|after_or_equal:' . now()->format('Y-m-d H:i:s'),
        ];
    }
}


class EventUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|max:255',
            'timestamp' => 'required|date_format:Y-m-d H:i:s|after_or_equal:' . now()->format('Y-m-d H:i:s'),
        ];
    }
}
