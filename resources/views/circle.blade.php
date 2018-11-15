@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{$community->name}}
                    @if ($community->user_id==Auth::id())
                    <div class="dropdown float-right">
                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                         Add Members
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <a class="dropdown-item" href="/communitymember/create?cmid={{$community->id}}">Using Form</a>
                          <a class="dropdown-item" href="#">From a File</a>
                        </div>
                    </div>
                    <a href="/communities/{{$community->id}}/edit" role="button" class="btn btn-secondary btn-sm float-right mr-1">Edit Circle</a>
                    <a href="/communities/{{$community->id}}/invite" role="button" class="btn btn-secondary btn-sm float-right mr-1">Invite members</a>
                    @endif
                </div>
                <div class="card-body">
                    <div class="container">
                        <div class="row">
                            @if ($community->image!="")
                            <div class="col-sm">
                                    <img src="{{ asset('storage/circles/'.$community->image) }}" alt="{{$community->name}}">
                            </div>
                            @endif
                            <div class="col-sm">
                                    {{$community->description}}
                            </div>
                            <div class="col-sm">
                            </div>
                        </div>
                    </div>
                    <div class="container mt-4">
                        <h3>Members:</h3>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                <th scope="col">Name</th>
                                <th scope="col">email</th>
                                <th scope="col">Phone</th>
                                @if ($community->user_id==Auth::id())
                                    <th scope="col"></th>
                                @endif
                                </tr>
                            </thead>
                                <tbody>
                                @foreach ($community->communityMembers as $member)
                                    <tr>
                                        <td>{{$member->name}}</td>
                                        <td>{{$member->email}}</td>
                                        <td>{{$member->phone}}</td>
                                        @if ($community->user_id==Auth::id())
                                            <td>
                                                <div class="row">
                                                    <div class="col-sm">
                                                        <a href="/communitymember/{{$member->id}}/edit?cmid={{$community->id}}"><img src="/svg/si-glyph-edit.svg" alt="Edit" title="Edit" /></a>                                                        </div>
                                                    <div class="col-sm">
                                                            <a href="#" ><img src="/svg/si-glyph-button-remove.svg" id="deleteMember" alt="Delete" title="Delete" data-member-id="{{$member->id}}" /></a>
                                                    </div>
                                                </div>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <form action="" method="post" id="deleteMemberForm" accept-charset="utf-8">
                            {{ csrf_field() }}
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="cmid" value="{{$community->id}}">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

