<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AboutStoreRequest extends FormRequest
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
            'page_id' => ['required', 'integer', 'exists:pages,id'],
            'name' => ['required', 'string'],
		    'email' => ['required', 'email'],
		    'phone' => 'required',
            'profession:'. app()->getLocale() => ['required', 'string'],
            'about_me:'. app()->getLocale() => ['required','string'],
        ];
    }
}
