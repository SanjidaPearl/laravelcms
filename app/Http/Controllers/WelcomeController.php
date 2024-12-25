<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller
{
    public function index(){
//        $status = Status::all();
        $status = Status::orderBy('id','desc')->get();
        return view('layouts.public',['status'=>$status]);
    }
}
