<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubjectValidation extends FormRequest
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
            'name'=>'required|max:255|unique:subjects'
        ];
    }

    public function messages()
        {
                return [
                    'required'=>'Назавние предмета обязательно к заполнению',
                    'max'=>'Длина названия не должна превышать 255 символов',
                    'unique'=>'Название предмета должно быть уникальным',
                ];
        }
}
