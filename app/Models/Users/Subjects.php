<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

use App\Models\Users\User;

class Subjects extends Model
{
    const UPDATED_AT = null;


    protected $fillable = [
        'subject'
    ];

    // (リレーション先のモデル名,リレーション先のテーブル名、自モデルの主キー、相手モデルの主キー)
    public function users(){
        return $this->belongsToMany('App\Models\Users\User', 'subject_users', 'subject_id', 'user_id');
    }
}
