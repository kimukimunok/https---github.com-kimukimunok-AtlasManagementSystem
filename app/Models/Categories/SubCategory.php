<?php

namespace App\Models\Categories;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
     // 更新時間のエラー出た為以下記述
    public $timestamps = false;
    // const UPDATED_AT = null;
    // const CREATED_AT = null;
    protected $fillable = [
        'main_category_id',
        'sub_category',
    ];
    // 一対多hasMany
    public function mainCategory(){
        // サブとメインのリレーションの定義
        return $this->belongsTo('App\Models\Categories\MainCategory');
    }
// withPivot→中間のテーブルのデータを取り出す。（サブカテゴリーIDを取り出す。）
    // 多対多の為belongToMany
    public function posts(){
        // ポストとサブのリレーションの定義
        return $this->belongsToMany('App\Models\Posts\Post', 'post_sub_categories', 'sub_category_id', 'post_id')->withPivot('sub_category_id');

    }
}
