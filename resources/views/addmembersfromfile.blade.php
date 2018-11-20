@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Add Members to {{$community->name}} from a file
                    <a href="/communities/{{$community->id}}" role="button" class="btn btn-secondary btn-sm float-right">back</a>
                </div>

                <div class="card-body">
                    <form action="{{ action('CommunityMemberController@store') }}" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="name" class="col-form-label">File</label>
                            <input type="file" class="form-control-file" id="file" name="file">
                        </div>
                        <input type="hidden" name="community_id" value="{{$community->id}}">
                        <input type="submit" value="Upload File" class="btn btn-primary" />

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

