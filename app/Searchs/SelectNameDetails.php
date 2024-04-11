<?php

namespace App\Searchs;

use App\Models\Users\User;

class SelectNameDetails implements DisplayUsers
{

    // 改修課題：選択科目の検索機能
    public function resultUsers($keyword, $category, $updown, $gender, $role, $subjects)
    {
        // 性別の選択がないとき
        if (is_null($gender)) {
            $gender = ['1', '2', '3'];
        } else {
            $gender = array($gender);
        }
        // 権限の選択がないとき
        if (is_null($role)) {
            $role = ['1', '2', '3', '4'];
        } else {
            $role = array($role);
        }

        $users = User::with('subjects')
            ->where(function ($q) use ($keyword) {
                $q->Where('over_name', 'like', '%' . $keyword . '%')
                    ->orWhere('under_name', 'like', '%' . $keyword . '%')
                    ->orWhere('over_name_kana', 'like', '%' . $keyword . '%')
                    ->orWhere('under_name_kana', 'like', '%' . $keyword . '%');
            })
            ->where(function ($q) use ($role, $gender) {
                $q->whereIn('sex', $gender)
                    ->whereIn('role', $role);
            })
            // selectidDetail.phpと同じで(where→whereInに変更)
            ->whereHas('subjects', function ($q) use ($subjects) {
                $q->whereIn('subject_id', $subjects);
            })
            ->orderBy('over_name_kana', $updown)->get();

        return $users;
    }
}
