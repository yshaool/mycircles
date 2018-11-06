@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                   Edit Circle - {{$community->name}}
                </div>
                <div class="card-body">
                    <form action="{{ action('CommunityController@update', ['id' => $community->id]) }}" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="name" class="col-form-label">Circle Name</label>
                            <input type="text" class="form-control col-sm-6" id="name" placeholder="Circle Name" name="name" value="{{ old('name', $community->name ?? $community->name ?? '') }}" />
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-form-label">Circle Description</label>
                            <textarea class="form-control col-sm-6" id="description" placeholder="Circle description" name="description" />{{ old('description', $community->description ?? $community->description ?? null) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="image">Circle Image</label>
                            <input type="file" class="form-control-file" id="image" name="image">
                        </div>
                        <input type="hidden" name="_method" value="PUT">
                        <input type="submit" value="Update" class="btn btn-primary" />
                    </form>
                    <br><br>
                    <div class="container">
                        <div><b>Current Image</b> (to keep it leave image field empty)</div>
                        <br>
                        <img src="{{ asset('storage/circles/'.$community->image) }}" alt="{{$community->name}}">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
