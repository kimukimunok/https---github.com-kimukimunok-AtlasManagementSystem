@extends('layouts.sidebar')

@section('content')
<div class="board_area w-100 border m-auto d-flex">
    <div class="post_view w-75 mt-5">
        <p class="w-75 m-auto"></p>

        @foreach($posts as $post)
        <!-- 投稿者の名前 -->
        <div class="post_area border w-75 m-auto">
            <p class="Post_Name"><span>{{ $post->user->over_name }}</span><span class="ml-3">{{ $post->user->under_name }}</span>さん</p>
            <p class="Post_Title"><a href="{{ route('post.detail', ['id' => $post->id]) }}">{{ $post->post_title }}</a></p>
            <div class="sub_category_comment d-flex">
                @foreach($post->subCategories as $sub_category)
                <p class="sub_category_name">
                    <!-- 修正箇所、投稿一覧のサブカテゴリーバッジがサブカテゴリーじゃなくてタイトルが表示されている。（$post->post_titleとなってた。） -->
                    <!-- foreachでデータを取得、サブカテゴリーズからではなく、ポストの中のサブカテゴリーを取得するから、記述は$post->subCategories as $sub_category-->
                    <a href="{{ route('post.detail', ['id' => $post->id]) }}">{{ $sub_category->sub_category }}</a>
                    @endforeach
                </p>
                <div class="post_bottom_area d-flex">
                    <div class="d-flex post_status">
                        <div class="mr-5">
                            <!-- まずここでコメントの数を表示させる。 -->
                            <i class="fa fa-comment"></i><span>{{$post->postComments->count()}}</span>
                        </div>
                        <div>
                            @if(Auth::user()->is_Like($post->id))
                            <p class="m-0"><i class="fas fa-heart un_like_btn" post_id="{{ $post->id }}"></i><span class="like_counts{{ $post->id }}">{{$post->likes->count()}}</span></p>
                            @else
                            <p class="m-0"><i class="fas fa-heart like_btn" post_id="{{ $post->id }}"></i><span class="like_counts{{ $post->id }}">{{ $post->likes->count() }}</span></p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="other_area ">
        <div class="">
            <div class="post_btn"><a href="{{ route('post.input') }}">投稿</a></div>
            <div class="keyword_search_btn">

                <span class="search_container">
                    <input class="text_box" type="text" placeholder="キーワードを入力" name="keyword" form="postSearchRequest">
                    <input class="keyword-btn" type="submit" value="検索" form="postSearchRequest"></span>
            </div>
            <!-- [いいねした投稿]と[自分の投稿]を横並びにして、それぞれにクラスをつけて色分けする。 -->
            <div class="btn_flex">
                <span class="post_like"><input type="submit" name="like_posts" class=" category_btn" value="いいねした投稿" form="postSearchRequest"></span>
                <span class="my_post">
                    <input type="submit" name="my_posts" class="category_btn" value="自分の投稿" form="postSearchRequest"></span>
            </div>
            <!-- この辺からカテゴリー選択 -->
            <!-- アコーディオンメニューが必要
            divカテゴリー検索,メイン検索,アコーディオンメニュー表示, -->
            <div class="accordion_container">
                <ul class="menu_items">
                    <p class="category_items">カテゴリー検索</p>

                    @foreach($categories as $category)
                    <div class="category-container">
                        <!-- data-ooで対象となるクラスやIDを入れられる各カテゴリーIDを持ってくる -->
                        <div class="accordion-push-js" data-target="{{ $category->id }}">

                            <div class="main_categories" category_id="{{ $category->id }}"><span>{{ $category->main_category }}</span></div>
                            <div class="accordion-push" data-target="{{ $category->id }}"></div>

                        </div>
                        <!-- divサブカテゴリーとサブカテゴリー選択のJS -->
                        <!-- ※ul liは子要素としての扱い、ulは外側を囲う要素、liは箇条書き要素一つ一つ。 -->
                        <ul class="sub_categories" data-category="{{ $category->id }}">
                            @foreach($category->subCategories as $sub_category)
                            <li class="sub_category" sub_category_id="{{ $sub_category->id }}">
                                <input type="submit" name="category_word" class="category_btn" value="{{ $sub_category->sub_category }}" form="postSearchRequest">
                            </li>
                            <!-- 3.23エラー出なくなったため多分正しい。JSとCSS探る -->
                            <!-- 3.26JS記述、とりあえずモーダルオープンはできた次はCSS、レイアウトみたいにする。？（ちなみにサブカテゴリー選択してもサブカテゴリーの投稿だけが表示されない状態だからそこもみたいよね。）→できた -->
                            @endforeach
                        </ul>
                    </div>
                    @endforeach
                </ul>
            </div>
            <form action="{{ route('post.show') }}" method="get" id="postSearchRequest"></form>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        </div>
        @endsection
