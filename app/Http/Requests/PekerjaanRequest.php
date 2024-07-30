<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PekerjaanRequest extends FormRequest
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
                'karyawan_id' => 'required',
                'nama_pekerjaan' => 'required',
                'tanggal_mulai' => 'required',
                'tanggal_selesai' => 'required',
                'deskripsi_pekerjaan' => 'required',
                'status_pekerjaan' => 'required',
            ];
        elseif($method === 'PUT')
            return [
                'karyawan_id' => 'required',
                'nama_pekerjaan' => 'required',
                'tanggal_mulai' => 'required',
                'tanggal_selesai' => 'required',
                'deskripsi_pekerjaan' => 'required',
                'status_pekerjaan' => 'required',
            ];
        else
            return [];
    }

    public function messages()
    {
        return [
            'karyawan_id.required' => 'kolom karyawan tidak boleh kosong.',
            'nama_pekerjaan.required' => 'kolom pekerjaan tidak boleh kosong.',
            'tanggal_mulai.required' => 'kolom tanggal mulai tidak boleh kosong.',
            'tanggal_selesai.required' => 'kolom tanggal selsai tidak boleh kosong.',
            'deskripsi_pekerjaan.required' => 'kolom deskripsi pekerjaan tidak boleh kosong.',
            'status_pekerjaan.required' => 'kolom status pekerjaan tidak boleh kosong.',
        ];
    }
}
