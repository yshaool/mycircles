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
                    <form action="{{ action('CommunityController@addMemberFromFile', ['id' => $community->id]) }}" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        @if (isset($membersArray))
                        <table class="table">
                            <thead>
                                <tr>
                                <th scope="col">&nbsp;</th>
                                @foreach ($guessedHeaders as $colGuess)
                                <th scope="col">
                                    <select class="form-control" id="col{{$loop->index}}" name="colHeadingNames[{{$loop->index}}]">
                                        <option value="">Please Select:</option>
                                    @foreach ($possibleColumnsNames as $possibleColName)
                                        <option value="{{$possibleColName}}" {{$colGuess==$possibleColName ? "selected" : ""}}>{{$possibleColName}}</option>
                                    @endforeach
                                    </select>
                                </th>
                                @endforeach
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($membersArray as $memberRow)
                            <tr>
                            <div class="row">
                                <td>
                                    @if (!$withHeaderRow || $loop->index!=0)
                                    <div><input class="form-check-input" type="checkbox" checked value="{{$loop->index}}" id="memberRowNum[]" name="memberRowNum[]"></div>
                                    @endif
                                </td>
                                @foreach ($memberRow as $memberField)
                                    <td>{{$memberField}}</td>
                                @endforeach
                            </div>
                            @endforeach

                            </tbody>
                        </table>
                        @endif
                        <a href="#" class="mr-4"><span id="checkall">Uncheck All</span></a>
                        <input type="submit" value="Add Selected Members" class="btn btn-primary" />
                        <br><br>
                        Existing memebers which has same email address will be updated.
                    </form>
                    <br><br>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection





