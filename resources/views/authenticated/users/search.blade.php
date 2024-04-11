@extends('layouts.sidebar')

@section('content')
<p>ユーザー検索</p>
<div class="search_content w-100 border d-flex">
    <div class="reserve_users_area">
        @foreach($users as $user)
        <div class="border one_person">
            <div>
                <span>ID : </span><span>{{ $user->id }}</span>
            </div>
            <div><span>名前 : </span>
                <a href="{{ route('user.profile', ['id' => $user->id]) }}">
                    <span>{{ $user->over_name }}</span>
                    <span>{{ $user->under_name }}</span>
                </a>
            </div>
            <div>
                <span>カナ : </span>
                <span>({{ $user->over_name_kana }}</span>
                <span>{{ $user->under_name_kana }})</span>
            </div>
            <div>
                @if($user->sex == 1)
                <span>性別 : </span><span>男</span>
                @elseif($user->sex == 2)
                <span>性別 : </span><span>女</span>
                @else
                <span>性別 : </span><span>その他</span>
                @endif
            </div>
            <div>
                <span>生年月日 : </span><span>{{ $user->birth_day }}</span>
            </div>
            <div>
                @if($user->role == 1)
                <span>権限 : </span><span>教師(国語)</span>
                @elseif($user->role == 2)
                <span>権限 : </span><span>教師(数学)</span>
                @elseif($user->role == 3)
                <span>権限 : </span><span>講師(英語)</span>
                @else
                <span>権限 : </span><span>生徒</span>
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
        <div class="">
            <div>
                <p>検索</p>
                <input type="text" class="free_word" name="keyword" placeholder="キーワードを検索" form="userSearchRequest">
            </div>
            <div>
                <lavel>カテゴリ</lavel>
                <select form="userSearchRequest" name="category">
                    <option value="name">名前</option>
                    <option value="id">社員ID</option>
                </select>
            </div>
            <div>
                <label>並び替え</label>
                <select name="updown" form="userSearchRequest">
                    <option value="ASC">昇順</option>
                    <option value="DESC">降順</option>
                </select>
            </div>
            <div class="">
                <!-- 右側サイドバーの検索条件側 -->
                <p class="m-0 search_conditions"><span>検索条件の追加</span></p>
                <div class="search_conditions_inner">
                    <div>
                        <label>性別</label>
                        <span>男</span><input type="radio" name="sex" value="1" form="userSearchRequest">
                        <span>女</span><input type="radio" name="sex" value="2" form="userSearchRequest">
                        <span>その他</span><input type="radio" name="sex" value="3" form="userSearchRequest">
                    </div>
                    <div>
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
                        <!-- 検索条件欄に選択科目の表示を追加 -->
                        <!-- 取得方法はforeachを使うため一覧画面と同じような記述になる？ -->
                        <!-- 選択科目全部を表示させて、 チェックボックスで選択できるようにする。-->
                        @foreach($AllSubjects as $subject)
                        <label>{{ $subject->subject }}
                            <input type="checkbox" name="subject_id[]" value=" {{ $subject->id }}" form="userSearchRequest">
                            <!-- データを送るにはname属性に注意が必要。適切に設定しないと連想配列としてデータを送れない。 -->
                            <!-- 今回のミス、name属性を暮らすか何かと勘違いして、記述しないでいた。→間違い。
                        name属性はフィールドの名前を指定するものとなるためこれが記入されていないとそもそもデータを受け渡しできない。
                    なので、ここでは選択科目識別のIDのsubject_idがフィールド名なので記述される。-->
                            <!-- name属性の後につく[]とは？ これを見ろ→https://zoomyc.com/blog/archives/2656/
                        複数選択が可能になるときはname属性のあとに[]をつける！！今回は選択科目は複数選択可能のため[]をつけなければならなかった。-->
                            <!--  -->
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>
            <div>
                <input type="submit" name="search_btn" value="検索" form="userSearchRequest">
            </div>
            <div>
                <input type="reset" value="リセット" form="userSearchRequest">
            </div>
        </div>
        <form action="{{ route('user.show') }}" method="get" id="userSearchRequest"></form>
    </div>
</div>
@endsection
