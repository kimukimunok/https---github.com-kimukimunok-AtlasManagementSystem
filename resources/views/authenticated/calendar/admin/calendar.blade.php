@extends('layouts.sidebar')


@section('content')
<div>
    <div class="calendar_back1">
        <div>
            <p class="calender_title text-center">{{ $calendar->getTitle() }}</p>
            <div>
                <p>{!! $calendar->render() !!}</p>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
