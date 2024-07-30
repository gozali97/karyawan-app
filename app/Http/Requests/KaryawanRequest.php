<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KaryawanRequest extends FormRequest
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
                'divisi_id' => 'required',
                'nama' => 'required',
                'alamat' => 'required',
                'foto' => 'required',
                'no_hp' => 'required',
                'tanggal_lahir' => 'required',
                'tanggal_masuk' => 'required',
                'status' => 'required',
            ];
        elseif($method === 'PUT')
            return [
                'divisi_id' => 'required',
                'nama' => 'required',
                'alamat' => 'required',
                'no_hp' => 'required',
                'tanggal_lahir' => 'required',
                'tanggal_masuk' => 'required',
                'status' => 'required',
            ];
        else
            return [];
    }

    public function messages()
    {
        return [
            'divisi_id.required' => 'kolom divisi tidak boleh kosong.',
            'nama.required' => 'kolom nama tidak boleh kosong.',
            'alamat.required' => 'kolom alamat tidak boleh kosong.',
            'foto.required' => 'kolom foto tidak boleh kosong.',
            'no_hp.required' => 'kolom no hp tidak boleh kosong.',
            'tanggal_lahir.required' => 'kolom tanggal lahir tidak boleh kosong.',
            'tanggal_masuk.required' => 'kolom tanggal masuk tidak boleh kosong.',
            'status.required' => 'kolom status tidak boleh kosong.',
        ];
    }
}
