@extends('layouts.sidebar')

@section('content')
<!-- 投稿(/bulletin_board/input)の画面 -->
<div class="post_create_container d-flex">
    <div class="post_create_area border w-50 m-5 p-5">
        <div class="">
            <!-- カテゴリー選択の場所 -->
            @if($errors->first('post_category_id'))
            <span class="error_message">{{ $errors->first('post_category_id') }}</span>
            @endif
            <!-- サブカテゴリーを選択できるようにする。（select） -->
            <p class="mb-0">カテゴリー</p>
            <select class="w-100" form="postCreate" name="post_category_id">
                @foreach($main_categories as $main_category)
                <!-- optgroupとは選択肢グループ要素→選択肢の中で大枠選択肢として表示させる。＝メインカテゴリーが大枠でサブカテゴリーが中枠みたいな -->
                <optgroup label="{{ $main_category->main_category }}">
                    <!-- メインカテゴリー(一つ)に登録されたサブカテゴリー(多数)のサブカテゴリーを出したい -->
                    @foreach ( $main_category->subcategories as $sub_category)
                    <!-- option value=(ID名)で、サブカテゴリーの情報を取得している -->
                    <option value="{{ $sub_category->id }}">{{ $sub_category->sub_category }}</option>
                    @endforeach
                </optgroup>
                @endforeach
            </select>
        </div>
        <div class="mt-3">
            <!-- if($errors->first('〇〇〇'))は特定のエラーメッセージを表示する。->allはまとめて、->firstは一つを表示 ※各項目にこのエラー出る記述必要ですよね-->
            @if($errors->first('post_title'))
            <span class="error_message">{{ $errors->first('post_title') }}</span>
            @endif
            <p class="mb-0">タイトル</p>
            <input type="text" class="w-100" form="postCreate" name="post_title" value="{{ old('post_title') }}">
        </div>
        <div class="mt-3">
            @if($errors->first('post_body'))
            <span class="error_message">{{ $errors->first('post_body') }}</span>
            @endif
            <p class="mb-0">投稿内容</p>
            <textarea class="w-100" form="postCreate" name="post_body">{{ old('post_body') }}</textarea>
        </div>
        <!-- 投稿ボタン -->
        <div class="mt-3 text-right">
            <input type="submit" class="btn btn-primary" value="投稿" form="postCreate">
        </div>
        <form action="{{ route('post.create') }}" method="post" id="postCreate">{{ csrf_field() }}</form>
    </div>
    <!-- 「can('admin')」ロールという。→設定管理者ユーザー(講師)のみが見られるようにする。()内の名前はAuthServiceProviderで定義している。 -->
    <!-- 今回の場合、メインカテゴリーとサブカテゴリーの追加がそう。 -->
    @can('admin')

    <form action="{{ route('main.category.create') }}" method="post" id="mainCategoryFrom">{{ csrf_field() }}</form>
    <div class="w-25 ml-auto mr-auto">
        <div class="category_area mt-5 p-5">
            <div class="">
                <!-- メインカテゴリーの追加 -->
                @if($errors->has('main_category_name'))
                <span class="error_message">{{ $errors->first('main_category_name') }}</span>
                @endif
                @if($errors->has('main_category_id'))
                <span class="error_message">{{ $errors->first('main_category_id') }}</span>
                @endif


                <p class="main_category_padding m-0">メインカテゴリー</p>
                <input type="text" class="w-100" name="main_category_name" form="mainCategoryFrom" id="mainCategoryInput">
                <input type="submit" value="追加" class="main_category_padding w-100 btn btn-primary p-0" form="mainCategoryFrom">

                <!--サブカテゴリーを追加 -->
                @if($errors->has('sub_category_name'))
                <span class="error_message">{{ $errors->first('sub_category_name') }}</span>
                @endif
                <p class="main_category_padding mb-0">サブカテゴリー</p>
                <select class=" w-100" form="subCategoryForm" name="main_category_id" id="mainCategoryId">
                    <!-- ---で選択無しを表示 -->
                    <option value="">---</option>
                    @foreach($main_categories as $main_category)
                    <!-- メインカテゴリー内にサブカテゴリーを入れる。→option value=(ID名)で、メインカテゴリーの情報を取得する→value="○○"はメインのid -->
                    <option value="{{ $main_category->id }}">{{ $main_category->main_category }}</option>
                    @endforeach
                </select>

                <form action="{{ route('sub.category.create') }}" method="post" id="subCategoryForm">{{ csrf_field() }}</form>
                <input type="text" class="main_category_padding w-100" name=" sub_category_name" form="subCategoryForm" id="subCategoryInput">
                <input type="submit" value="追加" class="main_category_padding w-100 btn btn-primary p-0" form="subCategoryForm">
            </div>
        </div>
        @endCan
        <!-- 管理者権限画面ここまで -->
    </div>
    @endSection
