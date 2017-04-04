<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{$title or "影片列表"}}</title>
    <link rel="stylesheet" href="{{asset('/css/app.css')}}"/>
    <link href="/css/video-js.min.css" rel="stylesheet">
    <style>
    #cursor {
    position: relative;
    background: red;
    z-index: 10;
    }
     .circle {
      height: 12px;
      width: 12px;
      border-radius: 50%;
    } 
.thumbnail-label {
  position: absolute; 
  top:90px;
  color: #fff;
  background: #3A87AD;
  font-weight: bold;
  font-size: 12px;
  left: 5px;
  max-width: 90px;
  text-align: center;
  padding: 2px 5px;
  cursor: pointer;
}

  </style>
</head>
<body>
   <div class="container-fluid" id="app">
    @yield('content')
   </div> 

   {{-- JavaScrtips --}}
   @section('scripts')
    <script src="{{asset('/js/app.js')}}"></script>
   @show
</body>
</html>