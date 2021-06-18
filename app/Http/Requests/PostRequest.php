<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            'title' => 'required',
            'content' => 'required',
            'status' => 'required|in:1,2,3',
            'user_id' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'El titulo es requerido',
            'content.required' => 'El contenido es requerido',
            'image.required' => 'La imagen es requerida',
            'image.image' => 'La imagen es requerida, debe ser de tipo jpeg, jppg o png'
        ];
    }
}
