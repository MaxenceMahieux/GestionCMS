<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubmenuRequest extends FormRequest
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
        return[
            'title' => 'required|string',
            'link' => 'required',
            'radio_choice' => 'required',
            'menu_id' => 'required'
        ];
    }
}
