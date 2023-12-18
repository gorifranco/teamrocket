<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ZonaRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'nom' => 'required|unique:espais,nom|max:100',
            'any_construccio' => 'required|date',
            'grau_accessibilitat' => 'required|in:baix,mitj,alt',
            'web' => 'nullable|url',
            'email' => 'required|email',
            'telefon' => 'required|regex:/^\d{10,}$/',
            'destacada' => 'prohibited',
            'fk_municipi' => 'required',
            'fk_tipusEspai' => 'required',
        ];
    }

    

}
