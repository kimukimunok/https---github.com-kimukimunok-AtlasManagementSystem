@extends('layouts.sidebar')


@section('content')
<div class="calender_detail_container">
    <div class="w-75 m-auto">
        <div class="w-100">
            <p class="calender_title">{{ $calendar->getTitle() }}</p>
            <p>{!! $calendar->render() !!}</p>
        </div>
    </div>
</div>
</div>
@endsection
