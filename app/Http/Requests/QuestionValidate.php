<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionValidate extends FormRequest
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
            'question'=>'required|max:255',
//            'question'=>'required|unique:questions,text|max:255',
            'answer.*.ans'=>'required|bail|max:255',
            'answer.*.file'=>'nullable|image',
            'image'=>'nullable|image',
//            'answer.correct'=>'required'
            //
        ];
    }

    public function messages()
    {
        return [
          'question.required' => 'Поле "вопрос" обязательно для заполнения',
//          'question.unique' => 'Такой вопрос уже существует',
            'image'=>'Загружаемые файлы должны быть изображениями',
          'answer.*.ans.required' => 'Поле "текст ответа" обязательно для заполнения',
//          'correct.required' => 'Хотя бы один ответ должен быть верным',
        ];
    }

}
