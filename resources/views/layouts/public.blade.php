@extends('layouts.layout')

@section('content')

@endsection

@section('status')
     @foreach($status as $st)
         <div class="container mt-3">
             <div class="row">
                 <div class="col-md-8 offset-md-2">
                     <div class="status shadow-sm" class="">
                         <div class="row p-3 pb-2">
                             <div class="col-md-10 p-3 pr-5">
                                 <div class="col-md-2">
                                     <img style="width:80px; height:80px;" src="{{ empty($st->user->avatar) ? asset('images/avatar.jpg') : $st->user->avatar}}"
                                          class="mt-3 rounded-circle img-thumbnail mx-auto d-block">
                                 </div>
                                 <p class="author">
                                     <strong>{{ $st->user->name }}</strong>
                                     <span class="date">{{ date('H:i A, dS M Y', strtotime($st->created_at))}}</span>
                                 </p>
                                 <p class="content">
                                     {{ $st['status'] }}
                                 </p>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     @endforeach
@endsection

@section('script')
{{--   <script> alert('hello'); </script>--}}
@endsection



{{--{{ route('shout.makefriend',$friendId)}}--}}
{{--{{ route('shout.unfriend',$friendId)}}--}}
