<?php

namespace App\Http\Controllers\Authenticated\BulletinBoard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories\MainCategory;
use App\Models\Categories\SubCategory;
use App\Models\Posts\Post;
use App\Models\Posts\PostComment;
use App\Models\Posts\Like;
use App\Models\Users\User;
use App\Http\Requests\BulletinBoard\PostEditRequest;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\BulletinBoard\PostFormRequest;
use App\Http\Requests\MainCategoryRequest;
use App\Http\Requests\SubCategoryRequest;
use Auth;

class PostsController extends Controller
{
    // 投稿を表示
    public function show(Request $request)
    {
        // $post=投稿
        $posts = Post::with('user', 'postComments')->get();
        // categories=メインカテゴリーのみ(ここにサブカテゴリー追加？)
        $categories = MainCategory::get();
        SubCategory::get();
        // like=いいね
        $like = new Like;
        // post_comment=投稿へのコメント
        $post_comment = new Post;
        // 検索箇所
        // 検索ワードが入力されていた時
        if (!empty($request->keyword)) {
            $posts = Post::with('user', 'postComments')
                ->where('post_title', 'like', '%' . $request->keyword . '%')
                ->orWhere('post', 'like', '%' . $request->keyword . '%')->get();
            // サブカテゴリーを検索できるようにする。orWhereで条件追加！！！！！
            // ->oiWhere();
            // カテゴリーワードの検索
        } else if ($request->category_word)
        //一覧のサブカテゴリーが選択されたとき
        {
            $sub_category = $request->category_word;
            $posts = Post::with('user', 'postComments')->get();
            // いいねした投稿が選択されたとき
        } else if ($request->like_posts) {
            $likes = Auth::user()->likePostId()->get('like_post_id');
            $posts = Post::with('user', 'postComments')
                ->whereIn('id', $likes)->get();
                // 自分の投稿が選択されたとき
        } else if ($request->my_posts) {
            $posts = Post::with('user', 'postComments')
                ->where('user_id', Auth::id())->get();
        }
        return view('authenticated.bulletinBoard.posts', compact('posts', 'categories', 'like', 'post_comment'));
    }

    public function postDetail($post_id)
    {
        $post = Post::with('user', 'postComments')->findOrFail($post_id);
        return view('authenticated.bulletinBoard.post_detail', compact('post'));
    }

    public function postInput()
    {
        $main_categories = MainCategory::get();
        return view('authenticated.bulletinBoard.post_create', compact('main_categories'));
    }
    // 投稿作成
    public function postCreate(PostFormRequest $request)
    {
        // bladeで投稿ボタンを押されたとき以下の処理を実行し、post.show(掲示板投稿画面)画面に遷移
        $post = Post::create([
            'user_id' => Auth::id(),
            'post_title' => $request->post_title,
            'post' => $request->post_body
        ]);
        // 投稿にサブカテゴリーを加えたい。
        // userとpostの間にsubcategoryを入れたい→中間テーブルに挿入（attach）を使用。
        // 投稿の中にpost_category_id(name属性)のサブカテゴリーを入れている。
        $post->subcategories()->attach($request->post_category_id);

        return redirect()->route('post.show');
    }

    // 投稿編集
    public function postEdit(PostEditRequest $request)
    {
        Post::where('id', $request->post_id)->update([
            'post_title' => $request->post_title,
            'post' => $request->post_body,
        ]);
        return redirect()->route('post.detail', ['id' => $request->post_id]);
    }
    // 投稿削除
    public function postDelete($id)
    {
        Post::findOrFail($id)->delete();
        return redirect()->route('post.show');
    }


    // メインカテゴリーの追加
    public function mainCategoryCreate(MainCategoryRequest $request)
    // public function mainCategoryCreate(Request $request)
    {
        MainCategory::create(['main_category' => $request->main_category_name]);

        return redirect()->route('post.input');
    }
    // サブカテゴリーの追加
    public function subCategoryCreate(SubCategoryRequest $request)
    // public function subCategoryCreate(Request $request)
    {

        // 元々あるメインカテゴリー(ID)を選び取得して、サブカテゴリーを送るようにしたい。
        $mainCategoryId = $request->input('main_category_id');
        $subCategoryName = $request->input('sub_category_name');

        // サブカテゴリーへ追加、登録
        $subCategory = new SubCategory();
        $subCategory->main_category_id = $mainCategoryId;
        $subCategory->sub_category = $subCategoryName;
        // 保存
        $subCategory->save();
        return redirect()->route('post.input');
    }


    // 投稿へのコメントを作成
    public function commentCreate(CommentRequest $request)
    {
        PostComment::create([
            'post_id' => $request->post_id,
            'user_id' => Auth::id(),
            'comment' => $request->comment
        ]);
        return redirect()->route('post.detail', ['id' => $request->post_id]);
    }
    // 自分の掲示板の投稿一覧
    public function myBulletinBoard()
    {
        $posts = Auth::user()->posts()->get();
        $like = new Like;
        return view('authenticated.bulletinBoard.post_myself', compact('posts', 'like'));
    }
    // いいねした投稿
    public function likeBulletinBoard()
    {
        $like_post_id = Like::with('users')->where('like_user_id', Auth::id())->get('like_post_id')->toArray();
        $posts = Post::with('user')->whereIn('id', $like_post_id)->get();
        $like = new Like;
        return view('authenticated.bulletinBoard.post_like', compact('posts', 'like'));
    }
    // いいねする機能
    public function postLike(Request $request)
    {
        $user_id = Auth::id();
        $post_id = $request->post_id;

        $like = new Like;

        $like->like_user_id = $user_id;
        $like->like_post_id = $post_id;
        $like->save();

        return response()->json();
    }
    //いいねを外す
    public function postUnLike(Request $request)
    {
        $user_id = Auth::id();
        $post_id = $request->post_id;

        $like = new Like;

        $like->where('like_user_id', $user_id)
            ->where('like_post_id', $post_id)
            ->delete();

        return response()->json();
    }
}
