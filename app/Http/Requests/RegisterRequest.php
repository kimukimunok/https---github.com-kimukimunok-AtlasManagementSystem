<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
// php artisan make:request RegisterRequestでバリデーションの為の子クラスを作成
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    // authorize→許可する。処理が許可されるかtrueかfalseで返す。falseだと処理が拒否されてしまう為基本的にはtrue
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
        // 以下バリデーション
        return [
            'over_name' => 'required|string|max:10',
            'under_name' => 'required|string|max:10',
            'over_name_kana' => 'required|string|regex:/^[ア-ヶー]+$/u|max:30',
            'under_name_kana' => 'required|string|regex:/^[ア-ヶー]+$/u|max:30',
            'mail_address' => 'required|email|unique:users|max:100',
            // 「in」選択項目以外を選択できないようにする。
            'sex' => 'required|in:1,2,3',
            // 日付かどうかは、各年月日が数値であるかどうかを判断する。(数値であるかどうかはnumeric)
            // 2000/1/1以降～は「date|after:1995-12-31」とする。
            // 年月日は連結して$birthdayでバリデーションを掛けるようにする。
            'old_year' => 'required|numeric',
            'old_month' => 'required|numeric',
            'old_day' => 'required|numeric',
            // before_or_equalは日付のバリデーション
            // format('Y-m-d')日付をフォーマットする（？）
            'birth_day'=>
            'required|date|after:1995-12-31|before_or_equal:' . now()->format('Y-m-d'),
            // 数字の項目を選択していないとエラーに出るようにする。
            'role' => 'required|in:1,2,3,4',
            'password' => 'required|string|min:8|max:30|confirmed',
        ];
        // dd($rules);
    }
    // 生年月日を結合し、$birth_dayをバリデーション出来るようにする。https://qiita.com/snbk/items/7f0767dfb305a52d41fb
    public function getValidatorInstance()
    {
        // 結合したい変数をinputで纏める
        if ($this->input('old_year') && $this->input('old_month') && $this->input('old_day')) {
            // 上の変数たちを$birth_day変数としてまとめる
            $birth_day = implode('-', $this->only(['old_year', 'old_month', 'old_day']));
            $this->merge([
                'birth_day' => $birth_day,
            ]);
        }

        return parent::getValidatorInstance();
    }

    //ここにエラーメッセージを入力
    // (attribute)カスタム属性変数(attributes)を編集することで、好きな値に変更できる。
    public function messages()
    {
        return [
            'required' => ':attributeは必ず入力してください。',
            'string' => ':attributeの形式で入力してください。',
            'email' => ':attributeの形式が正しくありません。',
            'regex' => ':attributeの形式で入力してください。',
            'unique' => ':attributeは既に使用されています。',
            'max' => ':attributeは:max文字以内で入力してください。',
            'min' => ':attributeは:min文字以上で入力してください。',
            'in' => '選択された:attributeが無効です。',
            'date_format' => ':attributeの形式が正しくありません。',
            'after' => ':attributeは2000年1月1日以降の日付を指定してください。',
            'confirmed' => ':attributeが一致しません。',
        ];
    }
    public function attributes()
    {
        return [
            'over_name' => '名前',
            'under_name' => '名前',
            'over_name_kana' => 'カタカナ',
            'under_name_kana' => 'カタカナ',
            'mail_address' => 'メールアドレス',
            'sex' => '性別',
            'birth_day' => '生年月日',
            'role' => '役職',
            'password' => 'パスワード',
        ];
    }
}
