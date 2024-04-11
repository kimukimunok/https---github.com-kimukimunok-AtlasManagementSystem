<?php

namespace App\Searchs;

use App\Models\Users\User;

class SelectIdDetails implements DisplayUsers
{

    // 改修課題：選択科目の検索機能
    //   キーワードを検索に入力されたとき
    public function resultUsers($keyword, $category, $updown, $gender, $role, $subjects)
    {
        if (is_null($keyword)) {
            $keyword = User::get('id')->toArray();
        } else {
            $keyword = array($keyword);
        }
        // 性別が選択されたとき
        if (is_null($gender)) {
            $gender = ['1', '2', '3'];
        } else {
            $gender = array($gender);
        }
        // 権限が選択されたとき
        if (is_null($role)) {
            $role = ['1', '2', '3', '4'];
        } else {
            $role = array($role);
        }
        // 選択科目が選択されたとき
        // pluck('id')で選択科目IDを取得する。
        // pluck=指定されたキーの値のみを抽出するためのメソッド
        if (is_null($subjects)) {
            $subjects = subjects::all->pluck('id')->toArray();
        } else {
            // array=配列を取り出す
            $subjects = array($subjects);
        }

        $users = User::with('subjects')
            ->whereIn('id', $keyword)
            ->where(function ($q) use ($role, $gender) {
                $q->whereIn('sex', $gender)
                    ->whereIn('role', $role);
            })
            // whereHasは検索条件の追加
            ->whereHas('subjects', function ($q) use ($subjects) {
                // 選択科目IDが登録情報とあっているかを検索したい。(whereからwhereInに)
                // whereInの記載方法は( '判定したいテーブル名.判定したいカラム名')であるから(subjects.subject_idと直した)
                $q->whereIn('subject_id', $subjects);
            })
            ->orderBy('id', $updown)->get();
        return $users;
    }
}
