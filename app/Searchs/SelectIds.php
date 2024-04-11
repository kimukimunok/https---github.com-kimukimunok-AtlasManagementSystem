<?php

namespace App\Searchs;

use App\Models\Users\User;

class SelectIds implements DisplayUsers
{

    // 改修課題：選択科目の検索機能
    // 入力されていないときのアクション？
    public function resultUsers($keyword, $category, $updown, $gender, $role, $subjects)
    {
        // 性別
        if (is_null($gender)) {
            $gender = ['1', '2', '3'];
        } else {
            $gender = array($gender);
        }
        // 権限
        if (is_null($role)) {
            $role = ['1', '2', '3', '4'];
        } else {
            $role = array($role);
        }
        // 選択科目(性別の部分を真似して記述した。)
        if (is_null($subjects)) {
            $subjects = ['1', '2', '3'];
        } else {
            $subjects = array($subjects);
        }
        // (null?)キーワードが入力されてなければ...?
        if (is_null($keyword)) {
            $users = User::with('subjects')
                ->whereIn('sex', $gender)
                ->whereIn('role', $role)
                ->orderBy('id', $updown)->get();
        }
        // 反対にキーワードが入力されていれば
        else {
            $users = User::with('subjects')
                ->where('id', $keyword)
                ->whereIn('sex', $gender)
                ->whereIn('role', $role)
                ->orderBy('id', $updown)->get();
        }

        return $users;
    }
}
