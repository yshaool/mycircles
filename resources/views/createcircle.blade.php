@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Create Circle
                    <a href="/communities" role="button" class="btn btn-secondary btn-sm float-right">back</a>
                </div>

                <div class="card-body">
                    <form action="{{ action('CommunityController@store') }}" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="name" class="col-form-label">Circle Name</label>
                            <input type="text" class="form-control col-sm-6" id="name" placeholder="Circle Name" name="name" value="{{ old('name', request('name') ?? request('name') ?? null) }}" />
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-form-label">Circle Description</label>
                            <textarea class="form-control col-sm-6" id="description" placeholder="Circle description" name="description" value="{{ old('description', request('description') ?? request('description') ?? null) }}" /></textarea>
                        </div>
                        <div class="form-group">
                            <label for="image">Circle Image</label>
                            <input type="file" class="form-control-file" id="image" name="image">
                        </div>

                        <input type="submit" value="Create" class="btn btn-primary" />

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

