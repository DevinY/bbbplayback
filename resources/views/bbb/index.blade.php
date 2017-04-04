@extends('layouts.app')

@section('content')
   <table class="table table-hover">
        <thead>
            <tr>
                <th>meeting_id</th>
                <th>會議名稱</th>
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
    {{$meetings->links()}}
@endsection