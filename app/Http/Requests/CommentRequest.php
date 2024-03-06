<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // trueに変更
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
            'comment' => 'required|string|max:2500'
        ];
    }

    public function messages()
    {
        return [
            'comment.required' => 'コメントは必ず入力してください',
            'comment.string' => 'コメントは文字列で入力してください',
            'comment.max' => 'コメントの最大文字数は2500文字です'
        ];
    }
}
