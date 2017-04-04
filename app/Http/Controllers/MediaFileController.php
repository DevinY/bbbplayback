<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MediaFileController extends Controller
{
    public function logo(){
        $file =public_path()."/images/logo.png";
        return response()->file($file);
    }

    public function file($internal){
        $file = storage_path()."/app/presentation/".$internal."/video/webcams.webm";
        return response()->file($file);
    }
    public function image($internalid, $imgid, $filename){
        $file = storage_path()."/app/presentation/".$internalid."/presentation/".$imgid."/".$filename;
        if($filename=='slide-0.png'){
        $file =public_path()."/images/logo.png";
        }
        return response()->file($file);
    }
}
