@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Upload Members to {{$community->name}} from a file
                    <a href="/communities/{{$community->id}}" role="button" class="btn btn-secondary btn-sm float-right">back</a>
                </div>

                <div class="card-body">
                    <form action="{{ action('CommunityController@parseMembersFileDisplayColSelection', ['id' => $community->id]) }}" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="name" class="col-form-label">Members List</label>
                            <input type="file" class="form-control-file" id="members-file" name="members-file">
                        </div>
                        <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="header-row" checked> File contains header row?
                                        </label>
                                    </div>
                                </div>
                            </div>
                        <input type="submit" value="Upload File" class="btn btn-primary" />
                    </form>
                    <br><br>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

