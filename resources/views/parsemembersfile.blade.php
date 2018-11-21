@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Add Members to {{$community->name}} from a file
                    <a href="/communities/{{$community->id}}/addmembersfromfile" role="button" class="btn btn-secondary btn-sm float-right">back</a>
                </div>

                <div class="card-body">
                    <form action="{{ action('CommunityController@index', ['id' => $community->id]) }}" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        @if (isset($membersArray))
                        <table class="table">
                            <thead>
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">First</th>
                                <th scope="col">Last</th>
                                <th scope="col">Handle</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($membersArray[0] as $memberRow)
                            <tr>
                            <div class="row">
                                <td><div><input class="form-check-input" type="checkbox" value="" id="memberrow" name="memberrow"></div></td>
                                @foreach ($memberRow as $memberField)
                                    <td>{{$memberField}}</td>
                                @endforeach
                            </div>
                            @endforeach

                            </tbody>
                        </table>
                        @endif
                        <input type="submit" value="Add Selected Members" class="btn btn-primary" />
                    </form>
                    <br><br>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection





