<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class imgStorageController extends Controller  {

    static public function UpdateImg($url){

        $url_for = str_replace('storage','public',$url);

        Storage::delete($url_for);
        return true;


    }

}
