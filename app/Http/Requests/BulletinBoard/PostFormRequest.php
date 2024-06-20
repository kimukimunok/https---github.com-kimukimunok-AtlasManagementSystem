<?php

namespace App\Http\Requests\BulletinBoard;

use Illuminate\Foundation\Http\FormRequest;

class PostFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    // true確認
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    // 投稿機能のバリデーション
    public function rules()
    {
        return [
            // [登録されているサブカテゴリーか]=DB内にサブカテゴリ―IDがあるか・・・を確認したい。
            // →'キー名'=> exists:テーブル名,存在チェックするID「https://anteku.jp/blog/develop/laravel-post%E3%81%95%E3%82%8C%E3%81%9F%E5%80%A4%E3%81%8C%E6%8C%87%E5%AE%9A%E3%81%95%E3%82%8C%E3%81%9F%E3%83%86%E3%83%BC%E3%83%96%E3%83%AB%E3%81%AE%E3%82%AB%E3%83%A9%E3%83%A0%E3%81%AB%E5%AD%98/」※存在が無い場合はバリデーション引っかからないっぽい
            'post_category_id' => 'required|exists:sub_categories,id',
            'post_title' => 'min:4|max:50',
            'post_body' => 'min:10|max:500',
        ];
    }

    public function messages()
    {
        return [
            'post_category_id.required' => 'メインカテゴリーは必ず選択してください。',
            'post_category_id.exists' => 'サブカテゴリーは存在しません。',
            'post_title.min' => 'タイトルは4文字以上入力してください。',
            'post_title.max' => 'タイトルは50文字以内で入力してください。',
            'post_body.min' => '内容は10文字以上入力してください。',
            'post_body.max' => '最大文字数は500文字です。',
        ];
    }
}
