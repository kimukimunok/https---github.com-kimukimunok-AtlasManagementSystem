<?php

namespace App\Models\Categories;

use Illuminate\Database\Eloquent\Model;

class MainCategory extends Model
{
    // 更新時間のエラー出た為以下記述
    public $timestamps = false;
    // const UPDATED_AT = null;
    // const CREATED_AT = null;
    protected $fillable = [
        'main_category'
    ];
// 一対多hasMany
    public function subCategories(){
        // メインとサブのリレーションの定義
        return $this->
        hasMany('App\Models\Categories\SubCategory');
    }
}
