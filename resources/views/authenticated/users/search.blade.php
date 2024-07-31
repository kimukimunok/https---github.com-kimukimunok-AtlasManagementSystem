@extends('layouts.sidebar')

@section('content')
<p>ユーザー検索</p>
<div class="search_content w-100 border d-flex">
    <div class="reserve_users_area">
        @foreach($users as $user)
        <div class="border one_person">
            <div>
                <span>ID : </span><span><b>{{ $user->id }}</b></span>
            </div>
            <div><span>名前 : </span>
                <a href="{{ route('user.profile', ['id' => $user->id]) }}">
                    <span>{{ $user->over_name }}</span>
                    <span>{{ $user->under_name }}</span>
                </a>
            </div>
            <div>
                <span>カナ : </span>
                <span><b>({{ $user->over_name_kana }} </b></span>
                <span><b>{{ $user->under_name_kana }}) </b></span>
            </div>
            <div>
                @if($user->sex == 1)
                <span>性別 : </span><span><b>男</b></span>
                @elseif($user->sex == 2)
                <span>性別 : </span><span><b>女</b></span>
                @else
                <span>性別 : </span><span><b>その他</b></span>
                @endif
            </div>
            <div>
                <span>生年月日 : </span><span><b>{{ $user->birth_day }}</b></span>
            </div>
            <div>
                @if($user->role == 1)
                <span>権限 : </span><span><b>教師(国語)</b></span>
                @elseif($user->role == 2)
                <span>権限 : </span><span><b>教師(数学)</b></span>
                @elseif($user->role == 3)
                <span>権限 : </span><span><b>講師(英語)</b></span>
                @else
                <span>権限 : </span><span><b>生徒</b></span>
                @endif
            </div>
            <div>
                @if($user->role == 4)
                <span>選択科目:
                    <!-- 一覧画面で選択科目の表示 -->
                    <!-- 選択科目(subjectを取得する。サブカテゴリー取得と同様) -->
                    @foreach($user->subjects as $subject)
                    <span>{{ $subject->subject }}</span></span>
                @endforeach
                @endif
            </div>
        </div>
        @endforeach
    </div>
    <!-- ここユーザー検索 -->
    <div class="search_area w-25 border">
        <div class="search_container">
            <div class="search_top">
                <p>検索</p>
                <input type="text" class="free_word" name="keyword" placeholder="キーワードを検索" form="userSearchRequest">
            </div>
            <div class="search_category">
                <label>カテゴリ</label>
                <select form="userSearchRequest" name="category">
                    <option value="name">名前</option>
                    <option value="id">社員ID</option>
                </select>
            </div>
            <div class="search_category">
                <label>並び替え</label>
                <select name="updown" form="userSearchRequest">
                    <option value="ASC">昇順</option>
                    <option value="DESC">降順</option>
                </select>
            </div>

            <!-- 右側サイドバーの検索条件側 -->
            <div class="sidebar_search">
                <p class="m-0 search_conditions accordion-push-js ">
                    <span class="search_border accordion-push">検索条件の追加
                    </span></p>
                <div class="search_conditions_inner">
                    <div>
                        <label>性別</label>
                        <p class="search_sex">
                            <span><b>男</b></span><input type="radio" name="sex" value="1" form="userSearchRequest">
                            <span><b>女</b></span><input type="radio" name="sex" value="2" form="userSearchRequest">
                            <span><b>その他</b></span><input type="radio" name="sex" value="3" form="userSearchRequest">
                        </p>
                    </div>
                    <div class="search_role">
                        <label>権限</label>
                        <select name="role" form="userSearchRequest" class="engineer">
                            <option selected disabled>----</option>
                            <option value="1">教師(国語)</option>
                            <option value="2">教師(数学)</option>
                            <option value="3">教師(英語)</option>
                            <option value="4" class="">生徒</option>
                        </select>
                    </div>
                    <div class="selected_engineer">
                        <label>選択科目</label>
                    </div>
                    @foreach($AllSubjects as $subject)
                    <div class="search_subject">
                        <label>{{ $subject->subject }}
                            <input type="checkbox" name="subject_id[]" value=" {{ $subject->id }}" form="userSearchRequest">
                    </div>
                    </label>
                    @endforeach
                </div>
            </div>


            <div class="search_btn">
                <input type="submit" name="search_btn" value="検索" form="userSearchRequest">
            </div>
            <div class="search_reset">
                <input type="reset" value="リセット" form="userSearchRequest">
            </div>
        </div>
        <form action="{{ route('user.show') }}" method="get" id="userSearchRequest"></form>
    </div>
</div>
@endsection
