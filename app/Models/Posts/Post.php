<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
     // 更新時間のエラー出た為以下記述
    public $timestamps = false;
    // const UPDATED_AT = null;
    // const CREATED_AT = null;

    // 参照したいテーブル名を指定するとエラー解除できるはず

    protected $fillable = [
        'user_id',
        'post_title',
        'post',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\Users\User', 'user_id');
    }

    // PostCommentとのリレーション
    public function postComments()
    {
        return $this->hasMany('App\Models\Posts\PostComment');
    }

    // コメント数のカウント
    public function commentCounts($post_id)
    {
        return Post::with('postComments')->find($post_id)->postComments();
    }
    // like.phpとのリレーション(1対多)
    public function likes()
    {
        return $this->hasMany(like::class, 'like_post_id');
        // likeのクラスからlike_post_idをもってきている。
        // like::class = class Like extends Modelってこと(?)
    }

    // サブカテゴリーのリレーション
    public function subCategories()
    {
        // サブとポストので多対多のbelongsToManyつかう
        return $this->belongsToMany('App\Models\Categories\SubCategory', 'post_sub_categories', 'post_id', 'sub_category_id');
    }
}
