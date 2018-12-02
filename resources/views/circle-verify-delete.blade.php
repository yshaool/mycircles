@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Delete Circle - {{$community->name}}
                    <a href="/communities/{{$community->id}}" role="button" class="btn btn-secondary btn-sm float-right">back</a>
                </div>

                <div class="card-body">
                    <h3>Are you 100% sure you wish to Delete - {{$community->name}}?</h3>
                    This action cannot be undone.<br>
                    The community and all its members will be deleted.<br><br><br>

                    <form action="{{ action('CommunityController@destroy', ['id' => $community->id]) }}" method="post" accept-charset="utf-8">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="submit" value="Yes. Delete this Circle!" class="btn btn-primary" />

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
