<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroupValidation extends FormRequest
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
            'name'=>'required|max:255|unique:groups',
        ];
    }

    public function messages()
    {
        return [
            'required'=>'Название группы обязательно к заполнению',
            'max'=>'Длина названия группы не должно превышать 255 символов',
            'unique'=>'Название группы должно быть уникальным',
        ];
    }
}
