@extends('layouts.layout')

@section('content')
    <div class="conatainer mb-5">
        <div class="row">
            <div class="colo-md-8 offset-md-2">
                <form action="{{ route('saveprofile') }}" method="POST" class="mt-5 mb-5" enctype="multipart/form-data">
                    @csrf
                    <h4 class="mb-5">Update Your Profile</h4>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" value="{{ Auth::user()->name }}" class="shadow-sm form-control">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" name="email" id="email" value="{{ Auth::user()->email }}" class="shadow-sm form-control">
                    </div>
                    <div class="form-group">
                        <label for="nickname">Nickname</label>
                        <input type="text" name="nickname" id="nickname" value="{{ Auth::user()->nickname }}" class="shadow-sm form-control">
                    </div>
                    <div class="form-group">
                        <label for="image">Profile Picture</label>
                        <input type="file" name="image" id="image" class="form-control-file">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="shadow-sm btn btn-primary mt-2 float-right pl-5 pr-5">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    {{--   <script> alert('hello'); </script>--}}
@endsection
