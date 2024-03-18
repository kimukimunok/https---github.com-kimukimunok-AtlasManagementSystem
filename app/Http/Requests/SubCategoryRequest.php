<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubCategoryRequest extends FormRequest
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
        $mainCategoryId = $this->input('main_category_id');
        return [
            'sub_category_name' =>
            'required|
                |string|
                |max:100'
        ];
    }
    // |exists:sub_categories,sub_category
    public function messages()
    {
        return [
            'sub_category_name.required' => 'サブカテゴリー名は必須です。',
            'sub_category_name.max' => 'サブカテゴリー名は100文字以内で入力してください。',
            'sub_category_name.string' => 'サブカテゴリー名は文字列で入力してください。',
            'sub_category_name.unique' => '同じ名前のサブカテゴリーはすでに存在します。'
        ];
    }
}
