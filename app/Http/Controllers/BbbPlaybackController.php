<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Meeting;
class BbbPlaybackController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
        $meetings = Meeting::orderBy('start_time','desc')->paginate(15);
        return view('bbb.index')
        ->with('meetings',$meetings);
    }

    public function login(){
        return view('login');
    }

    private static function cmp_obj($a, $b){
           return ($a['in']>$b['in']) ? +1: -1;
    }
   
    public function playback($internalid){
        $meeting = Meeting::where('internalid',$internalid)->first();
        //dd($meeting->meetingName);
        $title = $meeting->meetingId.$meeting->meetingName;

        $cursorfile = storage_path()."/app/presentation/".$internalid."/cursor.xml";
        $cursor = new \SimpleXMLElement(file_get_contents($cursorfile));
        $cursor_event = $cursor->xpath("//event");
        $cursor_data=[];
        foreach($cursor_event as $item){
            $left = explode(' ',$item->cursor)[0];
            $right = explode(' ',$item->cursor)[1];
            $cursor_data[]=[
                "timestamp"=>(String)$item['timestamp'],
                "left"=>$left,
                "top"=>$right
            ];
        }

        $slides_new = storage_path()."/app/presentation/".$internalid."/slides_new.xml";
        $slidesString = file_get_contents($slides_new);
        $chat = new \SimpleXMLElement( $slidesString );

        $chattimelines = $chat->xpath("//chattimeline");
        $chats = [];
        foreach($chattimelines as $item){
            $chats[]=[
                "in"=> $item['in'],
                "name"=> $item['name'],
                "message"=>$item['message']
            ];
        }

        $svg_path = storage_path()."/app/presentation/".$internalid."/shapes.svg";
        $svgString = file_get_contents($svg_path);
        $svg = new \SimpleXMLElement( $svgString );
        $slides = $svg->xpath("//*[local-name() = 'image']");
        $images = $svg->xpath("//@xlink:href");
        //取得image path
        $image_path = preg_replace('/slide-\\d+.png/us', '', (String)$images[0]); 
        $images = array_merge(['logo.png'], $images);

        $data=[]; 
        foreach($slides as $item){
            //一個圖來回點會有多個in out時間
            $arrin = explode(' ',$item['in']);
            $arrout = explode(' ',$item['out']);
            foreach($arrin as $in_index=>$in){
                $imageid  = (String)$item['id'];
                $slideimg = sprintf("%sslide-%s.png",$image_path, preg_replace('/(image)(\\d+)/us', '$2', $imageid));
                $data[]=[
                "id"=>$imageid,
                "itime"=>gmdate("H:i:s", $in),
                "otime"=>gmdate("H:i:s", $arrout[$in_index]),
                "in"=>$in,
                "out"=>$arrout[$in_index],
                "image" => $slideimg
                ];
            }
        }
        
        usort($data, array('App\Http\Controllers\BbbPlaybackController','cmp_obj'));
        $cursor_data=[];

        return view('bbb.playback',[
            'title'=>$title,
            'internalid'=>$internalid, 
            'slides'=>$slides,
            'chattimelines'=>$chats,
            'cursor_data'=>$cursor_data,
            'data'=>$data]);
    }
}
