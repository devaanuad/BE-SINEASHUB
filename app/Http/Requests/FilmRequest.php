<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilmRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'judul' => 'required|string',
            'tumbnail' => 'required|image',
            'deskripsi' => 'required|string',
            'url_trailer' => 'required',
            'status' => 'required|in:coming soon,rilis',
            'url_film' => 'nullable',
            'rating' => 'nullable',
            'tanggal_terbit' => 'required|date',
            'harga' => 'required|integer',

        ];
    }
}
