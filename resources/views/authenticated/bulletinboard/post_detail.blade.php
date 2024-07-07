@extends('layouts.sidebar')
@section('content')
<div class="vh-100 d-flex">
    <div class="w-50 mt-5">
        <div class="m-3 detail_container">
            <div class="p-3">
                <!-- ■投稿編集機能
                ・入力値に対してバリデーションを適用する
                ・バリデーションの条件は「簡易基本設計書」を参照
                ・自分の投稿にのみ編集ボタンを表示
                ■投稿削除機能
                ・削除ボタンをクリックするとモーダルで表示させる
                ・自分の投稿にのみ削除ボタンを表示 -->
                <!-- ログインユーザーと投稿した人が同じとき、編集ボタンを有効にする(Auth)―確認OK -->
                @if (Auth::user()->id == $post->user_id)
                <div class="detail_inner_head">
                    <div>
                        <!-- ここにサブカテゴリーの名称を表示させる記述をする。 -->
                        <!-- foreachにてsub_categoryを取得する。 -->
                        @foreach($post->subCategories as $sub_category)
                        <span class="posts_sub_category">{{ $sub_category->sub_category }}</span>
                        @endforeach
                    </div>
                    <div>
                        <!-- 投稿編集 -->
                        <span class="edit-modal-open" post_title="{{ $post->post_title }}" post_body="{{ $post->post }}" post_id="{{ $post->id }}">編集</span>
                        <!-- 投稿削除-確認OK -->
                        <a class="post-delete" href="{{ route('post.delete', ['id' => $post->id]) }}" onclick="return confirm('こちらの投稿を削除してもよろしいでしょうか？')">削除</a>
                    </div>
                </div>
                @endif
                <div class="padtop_15 contributor d-flex">
                    <p>
                        <span>{{ $post->user->over_name }}</span>
                        <span>{{ $post->user->under_name }}</span>
                        さん
                    </p>
                    <span class="ml-5">{{ $post->created_at }}</span>
                </div>
                @if ($errors->has('post_title'))
                <span class="error_message"> {{$errors->first('post_title')}}</span>
                @endif

                <div class="detsail_post_title">{{ $post->post_title }}</div>
                <div class="mt-3 detsail_post">{{ $post->post }}</div>
            </div>
            @if ($errors->has('post_body'))
            <span class="error_message">{{$errors->first('post_body')}}
            </span>
            @endif

            <div class="p-3">
                <div class="comment_container">
                    <span class="">コメント</span>
                    @foreach($post->postComments as $comment)
                    <div class="comment_area border-top">
                        <p>
                            <span>{{ $comment->commentUser($comment->user_id)->over_name }}</span>
                            <span>{{ $comment->commentUser($comment->user_id)->under_name }}</span>さん
                        </p>
                        <p>{{ $comment->comment }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="w-50 p-3">
        <div class="comment_container border m-5">
            <div class="comment_area">
                <!--  -->
                @if($errors->first('comment'))
                <p class="error_message">{{ $errors->first('comment') }}</p>
                @endif
                <p class="m-0">コメントする</p>
                <textarea class="post_comment_textarea w-100" name="comment" form="commentRequest"></textarea>
                <input type="hidden" name="post_id" form="commentRequest" value="{{ $post->id }}">
                <input type="submit" class="btncomentpost btn btn-primary" form="commentRequest" value="投稿">
                <form action="{{ route('comment.create') }}" method="post" id="commentRequest">{{ csrf_field() }}</form>
            </div>
        </div>
    </div>
</div>
<!-- キャンセルモーダル -->
<div class="modal js-modal">
    <div class="modal__bg js-modal-close"></div>
    <div class="modal__content">
        <form action="{{ route('post.edit') }}" method="post">
            <div class="w-100">
                <div class="modal-inner-title w-50 m-auto">
                    <input type="text" name="post_title" placeholder="タイトル" class="w-100">
                </div>
                <div class="modal-inner-body w-50 m-auto pt-3 pb-3">
                    <textarea placeholder="投稿内容" name="post_body" class="w-100"></textarea>
                </div>
                <!-- モーダル閉じるボタン -->
                <div class="w-50 m-auto edit-modal-btn d-flex">
                    <a class="js-modal-close btn btn-danger d-inline-block" href="">閉じる</a>
                    <input type="hidden" class="edit-modal-hidden" name="post_id" value="">
                    <input type="submit" class="btn btn-primary d-block" value="編集">
                </div>
            </div>
            {{ csrf_field() }}
        </form>
    </div>
</div>
@endsection
