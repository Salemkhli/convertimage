<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class imagecontroller extends Controller
{
    public function contact(){
        $animal=array('i'=>'cat','b'=>'lion');
        $name=array(1=>'good',2=>'nice');

        return view('contact')->with('animal',$animal)->with('name',$name);
    }
    public function getpost(){
        return "hello this is submitted my friend";
    }

}
