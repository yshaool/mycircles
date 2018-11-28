@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{$user->name}} Profile
                    <a href="/users/{{$user->id}}/edit" role="button" class="btn btn-secondary btn-sm float-right mr-1">Edit My Profile</a>
                    <!--<a href="/users/{{$user->id}}/" role="button" class="btn btn-secondary btn-sm float-right mr-1">Add Special Offers</a>-->
                </div>
                <div class="container">
                    <div class="row">
                      <div class="col-md-6 img text-center">
                        <br>
                        @if ($user->image!="")
                        <img src="{{ asset('storage/users/'.$user->image) }}"  alt="{{$user->name}}" class="rounded">
                        @else
                        <img src="{{ asset('storage/images/no_avatar.jpg') }}"   alt="{{$user->name}}" class="rounded">
                        @endif
                        <br>
                        <br>
                      </div>
                      <div class="col-md-6 details mt-4">
                        <blockquote>
                          <h5>{{$user->name}}</h5>
                          <b>Address:</b> <small><cite title="Source Title">{{$user->address}}<i class="icon-map-marker"></i></cite></small>
                        </blockquote>
                        <p>
                                <b>{{$user->email}}</b> <br>
                                <b>phone:</b> {{$user->phone}} <br>
                                <b>profession:</b> {{$user->profession}} <br>
                                <b>services:</b> {{$user->services}}
                        </p>
                      </div>
                    </div>
                  </div>

            </div>
        </div>
    </div>
</div>
@endsection

