@extends('layouts.sidebar')

@section('content')
<div class="vh-100 border">
    <div class="profile_top">
        <span>{{ $user->over_name }}</span><span>{{ $user->under_name }}さんのプロフィール</span>
    </div>

    <div class=" top_area w-75 m-auto pt-5 ">
        <div class="user_status p-3">
            <p>名前 : <span>{{ $user->over_name }}</span><span class="ml-1">{{ $user->under_name }}</span></p>
            <p>カナ : <span>{{ $user->over_name_kana }}</span><span class="ml-1">{{ $user->under_name_kana }}</span></p>
            <p>性別 : @if($user->sex == 1)<span>男</span>@else<span>女</span>@endif</p>
            <p>生年月日 : <span>{{ $user->birth_day }}</span></p>
            <div>選択科目 :
                @foreach($user->subjects as $subject)
                <span>{{ $subject->subject }}</span>
                @endforeach
            </div>
            <div class="subject_edit accordion-push-js">
                @can('admin')
                <span class="subject_edit_btn accordion-push">選択科目の登録</span>
                <div class="subject_inner ">
                    <form action="{{ route('user.edit') }}" method="post">
                        @foreach($subject_lists as $subject_list)
                        <div class="profile_subject">
                            <label>{{ $subject_list->subject }}</label>
                            <input type="checkbox" name="subjects[]" value="{{ $subject_list->id }}">
                        </div>
                        @endforeach
                        <input type="submit" value="登録" class="btn btn-primary">
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        {{ csrf_field() }}
                    </form>
                </div>
                @endcan
            </div>
        </div>
    </div>
</div>
</div>

@endsection
