<?php

namespace App\Searchs;

// 改修課題：選択科目の検索機能
// インターフェースメソッドとは、、https://laraweb.net/surrounding/1985/　よくわからん
interface DisplayUsers
{
    public function resultUsers($keyword, $category, $updown, $gender, $role, $subjects);
}


// インターフェースとは、インターフェースとは、クラスがメソッド持っていることを定義するオブジェクト指向の仕組み。
