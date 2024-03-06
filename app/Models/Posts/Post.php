<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;

    protected $fillable = [
        'user_id',
        'post_title',
        'post',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\Users\User');
    }

    // PostCommentとのリレーション
    public function postComments()
    {
        return $this->hasMany('App\Models\Posts\PostComment');
    }

    public function subCategories()
    {
        // リレーションの定義
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
}
