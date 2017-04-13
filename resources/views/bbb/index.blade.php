@extends('layouts.app')

@section('content')
<div class="form-inline">
<form action="/bbb" method="GET">
<label>Meeting ID:</label>
<input type="text" name="search" class="form-control" value="{{$search or ""}}" >
<button type="submit" class="btn btn-default">Search</button>
</form>
</div>
   <table class="table table-hover">
        <thead>
            <tr>
                <th>meeting_id</th>
                <th>@lang('bbb.Meeting Name')</th>
                <th>start_time</th>
                <th>end_time</th>
            </tr>
        </thead>
        <tbody>
            @foreach($meetings as $meeting)
            <tr>
                <td>
                    <a href="/playback/{{$meeting->internalid}}" target="_blank">
                        {{$meeting->meetingId}}
                    </a>
                </td>
                <td>{{$meeting->meetingName}}</td>
                <td>{{$meeting->start_time}}</td>
                <td>{{$meeting->end_time}}</td>
            </tr>
            @endforeach
        </tbody>
    </table> 
    {{$meetings->appends(Request::except(['page']))->links()}}
@endsection