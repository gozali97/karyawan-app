<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DivisiRequest extends FormRequest
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
        $method = $this->method();

        if($method === 'POST')
            return [
                'nama_divisi' => 'required',
            ];
        elseif($method === 'PUT')
            return [
                'nama_divisi' => 'required',
            ];
        else
            return [];
    }

    public function messages()
    {
        return [
            'nama_divisi.required' => 'kolom divisi tidak boleh kosong.',
        ];
    }
}
