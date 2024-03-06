<?php

namespace App\Http\Requests\BulletinBoard;

use Illuminate\Foundation\Http\FormRequest;

class PostEditRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // 下をtrueにして機能を有効にする
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    // 投稿編集バリデーション
    public function rules()
    {
        return [
            // カテゴリーは選ばないから、タイトルと投稿内容のみ
            'post_title' => 'required| string | max:100',
            'post_body' => 'required | string | max:5',
        ];
    }
    public function messages()
    {
        return [
            // 必須項目など、使われることが何度かあるものには:attributeを使用するよい。
            'required' => ':attributeは必ず入力してください',
            'post_category_id.exists' => '選択された投稿カテゴリーが無効です',
            'post_title.string' => ':attributeは文字列で入力してください',
            'post_title.max' => '投稿タイトルは100文字以内で入力してください',
            'post_body.max' => '投稿内容は5000文字以内で入力してください',
        ];
    }

    public function attributes()
    {
        return [
            'post_title' => '投稿タイトル',
            'post_body' => '投稿内容',
        ];
    }
}
// バリデーションをしたいメソッドを編集するのを忘れないように。
