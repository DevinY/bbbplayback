@extends('bbb.layout.master')
@section('content')
<table class="table table-hover" style="width:1350px">
    <tbody>
        <tr>
            <td class="col-xs-2">
                <div style="height:600px; overflow-x: scroll;">
                <table class="table table-hover slides">
                        <tbody>
                            @foreach($data as $i=>$item)
                            @if($i==0) 
                            @continue;;
                            @endif
                            <tr class="default">
                                <td>
                                <div style="position: relative">
								   @if(!empty($item['image']))
								   <img src="/image/{{$internalid}}/{{$item['image']}}" 

                                    @if($i==0)
                                    class="hide"
                                    @endif
                                    in="{{$item['in']}}"
                                    out="{{$item['out']}}"
                                    style="width:150px;"
                                    >
								   @endif
                                    <span style="" class="hide thumbnail-label itime">{{$item['itime']}}</span>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div> 
            </td>
            <td class="col-xs-8">
               <div id="presentation">
                <div class="circle" id="cursor" style="visibility: visible; left: 69px; top: 369px;"></div>
                <img src="/image/{{$internalid}}/logo.png"
                id="present"
                style="width:800px;"
                >
            </div> 
        </td>
        <td class="col-xs-2">
           <video id={{$internalid}} width=400  class="video-js vjs-default-skin" controls>
              <source src="/video/{{$internalid}}" type="video/webm"></source>
          </video>
          <div id="chat-area" style="height:300px; overflow-x: scroll;">
              <div id="chats">
              </div> 
          </div>
      </td>
  </tr>
</tbody>
</table>

@endsection

@section('scripts')
@parent
<script src="/js/video.min.js"></script>
<script>
    var player = videojs('{{$internalid}}');
    var imgdata = {!!json_encode($data)!!};
    var chats = {!!json_encode($chattimelines)!!};
    var cursor_data = {!!json_encode($cursor_data)!!};
    player.play();
    var time_temp=0;
    var img_in=0; 
    //游標移動 
    var setCursor = function(ct){
        var kindex=0;
        arr = cursor_data.filter(
            function(item){
                return item.timestamp>=ct; 
            });
        var i = cursor_data.length-arr.length;
        try{
            if(ct>time_temp){
                $( "#cursor" ).animate({left:cursor_data[i].left,top:cursor_data[i].top}).show();
            }
            time_temp = cursor_data[i].timestamp; 
        }catch(e){
            $('#cursor').hide();
        }
    }

    var setChats = function(ct){
       //聊天顯示
       var chat_string="";
       chats.forEach(function(item){
        if(ct>=item.in[0]){
            chat_string=chat_string+item.name[0]+":"+item.message[0]+"<br/>";
        }
    });
       $("#chats").html(chat_string);
   	   $('#chat-area').animate({scrollTop: $("#chats")[0].scrollHeight }, 'slow');
   }


   var setSlides = function(ct){
    arr = imgdata.filter(
        function(item){
            return item.in>=ct; 
        });
    var i = imgdata.length-arr.length;
    if(ct>img_in){
        var src = "/image/{{$internalid}}/"+imgdata[i-1].image;
		if(src.match(/.png$/i)){
			  $("img#present").attr("src", src);
		}
    }
}

setInterval(function(){ 
   var whereYouAt = player.currentTime();
   setCursor(whereYouAt);
   setChats(whereYouAt);
   setSlides(whereYouAt);
}, 1000);

$("img").on('click', function(){
    $(".itime").addClass("hide");
    $(this).next().removeClass("hide");

    $("table.slides tr").removeClass('info');
    $(this).closest('tr').addClass('info');

    time_temp=0;
    var intime = $(this).attr("in");
    player.currentTime(intime);
    $("#chat").empty();
});
</script>
@stop
