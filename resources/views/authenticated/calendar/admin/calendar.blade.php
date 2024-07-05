@extends('layouts.sidebar')


@section('content')
<div class="calender_detail_container">
    <div class="w-75 m-auto">
        <div class="w-100 reserve-check" style="border-radius:5px;">
            <p class="calender_title text-center">{{ $calendar->getTitle() }}</p>
            <div>
                <p>{!! $calendar->render() !!}</p>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
