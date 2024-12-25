<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Models\User;
use App\Models\Friend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index(){
        return view('home');
    }
    public function shoutHome(){
        $userId = Auth::id();
//        $status = Status::where('user_id',$userId)->get();
        if(Friend::where('user_id',$userId)->where('friend_id',$userId)->count()==0){
            $friendship = new Friend();
            $friendship->user_id = $userId;
            $friendship->friend_id = $userId;
            $friendship->save();
        }
        $status = Auth::user()->friendsStatus;

//        $avatar = empty(Auth::user()->avatar) ? asset('images/avatar.jpg'): Auth::user()->avatar;
        $avatar =  Auth::user()->avatar;
        return view('layouts.shouthome',['status'=>$status, 'avatar'=>$avatar]);
    }
    public function publicTimeline($nickname){
        $user = User::where('nickname',$nickname)->first();
        if($user){
            $status = Status::where('user_id', $user->id)->get();
            $avatar = empty($user->avatar) ? asset('images/avatar.jpg') : $user->avatar;
            $name = $user->name;
            $displayActions = false;
            if(Auth::check())
            {
                if(Auth::user()->id != $user->id){
                    $displayActions = true;
                }
            }
            return view('layouts.shoutpublic',[
                'status' => $status,
                'avatar' => $avatar,
                'name' => $name,
                'displayActions' => $displayActions,
                'friendId' => $user->id
                ]);
        }else{
            return redirect('/');
        }
   }
    public function saveStatus(Request $request){
        if(Auth::check()){
            $status = $request->post('status');
            $userId = Auth::id();
            $statusModel = new Status();
            $statusModel->status = $status;
            $statusModel->user_id = $userId;
            $statusModel->save();
            return redirect()->route('shout');
        }
    }
    public function saveProfile(Request $request){
         if(Auth::check()){
             $request->validate([
                 'name' => 'required|string|max:255',
                 'email' => 'required|email|max:255',
                 'nickname' => 'required|string|max:255',
                 'image' => 'required|file|mimes:jpg,jpeg,png|max:2048',
             ]);

             $user = Auth::user();
             $user->name = $request->name;
             $user->email = $request->email;
             $user->nickname = $request->nickname;
             $profielImage = 'user'.$user->id.'.'.$request->image->extension();
             $request->image->move(public_path('images'),$profielImage);

             $user->avatar = asset("images/{$profielImage}");

             $user->save();
             return redirect()->route('profile');
         }
    }
    public function profile(){

        return view('layouts.profile');
    }
    public function makeFriend($friendId){
        $user_id = Auth::user()->id;
        if (Friend::where('user_id', $user_id)->where('friend_id', $friendId)->count() == 0) {
            $friendship = new Friend();
            $friendship->user_id = Auth::user()->id;
            $friendship->friend_id = $friendId;
            $friendship->save();
        }
        if (Friend::where('friend_id', $friendId)->where('user_id', $user_id)->count() == 0) {
            $friendship = new Friend();
            $friendship->friend_id = Auth::user()->id;
            $friendship->user_id = $friendId;
            $friendship->save();
        }
        return redirect()->route('shout');
    }
    public function unFriend($friendId){
        $user_id = Auth::user()->id;
        Friend::where('user_id', $user_id)->where('friend_id', $friendId)->delete();
        Friend::where('friend_id', $friendId)->where('user_id', $user_id)->delete();
        return redirect()->route('shout');
    }

}
