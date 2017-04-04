@extends('bbb.layout.master')

@section('content')
  <form action="/login" method="POST" role="form">
        {{csrf_field()}}
        <legend>Login page</legend>

        <div class="form-group">
            <label for="">Email</label>
            <input type="text" class="form-control" name="email">
            <label for="">Password</label>
            <input type="password" class="form-control" name="password">
        </div>
    
        <button type="submit" class="btn btn-primary">登入</button>
    </form>  
@endsection