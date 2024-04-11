<?php

namespace App\Searchs;

use App\Models\Users\User;

class SelectNames implements DisplayUsers
{

    public function resultUsers($keyword, $category, $updown, $gender, $role, $subjects)
    {
        // 性別
        if (empty($gender)) {
            $gender = ['1', '2', '3'];
        } else {
            $gender = array($gender);
        }
        // 権限
        if (empty($role)) {
            $role = ['1', '2', '3', '4'];
        } else {
            $role = array($role);
        }
        // 選択科目
        if (empty($subjects)) {
            $subjects = ['1', '2', '3'];
        } else {
            $subjects = array($subjects);
        }
        $users = User::with('subjects')
            ->where(function ($q) use ($keyword) {
                $q->where('over_name', 'like', '%' . $keyword . '%')
                    ->orWhere('under_name', 'like', '%' . $keyword . '%')
                    ->orWhere('over_name_kana', 'like', '%' . $keyword . '%')
                    ->orWhere('under_name_kana', 'like', '%' . $keyword . '%');
            })->whereIn('sex', $gender)
            ->whereIn('role', $role)
            ->orderBy('over_name_kana', $updown)->get();

        return $users;
    }
}
