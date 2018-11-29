@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{$community->name}}

                    @if ($community->user_id==Auth::id())
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                            <a class="navbar-brand" href="#"></a>
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                              <span class="navbar-toggler-icon"></span>
                            </button>

                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                              <ul class="navbar-nav mr-auto">
                                <li class="nav-item">
                                    <a href="/communities/{{$community->id}}/edit" role="button" class="nav-link float-right mr-1">Edit Circle</a>
                                </li>
                                <li class="nav-item">
                                    <a href="/communities/{{$community->id}}/showinvite" role="button" class="nav-link float-right mr-1">Invite members</a>
                                </li>
                                <li class="nav-item">
                                    <a href="/communities/{{$community->id}}/downloadmembers" role="button" class="nav-item nav-link float-right mr-1">Download members</a>
                                </li>


                                <li class="nav-item dropdown">
                                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Add Members
                                  </a>
                                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="/communitymember/create?cmid={{$community->id}}">Using Form</a>
                                    <a class="dropdown-item" href="/communities/{{$community->id}}/addmembersfromfile">From a File</a>
                                  </div>
                                </li>
                              </ul>
                            </div>
                    </nav>
                    @endif
                </div>
                @mobile
                    <div class="card-body p-0">
                @elsemobile
                    <div class="card-body p-3">
                @endmobile
                    <div class="container mt-3">
                        <div class="row">
                            @if ($community->image!="")
                            <div class="col-sm">
                                    <img src="{{ asset('storage/circles/'.$community->image) }}" alt="{{$community->name}}" style="max-width:90%;">
                            </div>
                            @endif
                            <div class="col-sm">
                                    {{$community->description}}
                            </div>
                            <div class="col-sm">
                            </div>
                        </div>
                    </div>
                    <div class="container mt-4 p-0">
                        <h3 class="ml-1">Members:</h3>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                <th scope="col">Name</th>
                                @notmobile
                                    <th scope="col">email</th>
                                    <th scope="col">Phone</th>
                                @elsenotmobile
                                    <th scope="col" class="text-center"><span class="font-size: 1.4em; color: #4d4d4d;"><i class="fas fa-mail-bulk"></i></span></th>
                                    <th scope="col" class="text-center"><span class="font-size: 1.4em; color: #4d4d4d;"><i class="fas fa-phone"></i></span></th>
                                @endnotmobile

                                @if ($community->user_id==Auth::id())
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                @endif
                                </tr>
                            </thead>
                                <tbody>
                                @foreach ($community->communityMembers as $member)
                                    <tr>
                                        <td nowrap>{{$member->name}}</td>
                                        @notmobile
                                            <th scope="col"><a href="mailto:{{$member->email}}" target="_blank">{{$member->email}}</a></th>
                                            <th scope="col">{{$member->phone}}</th>
                                        @elsenotmobile
                                            <th scope="col" class="text-center"><a href="mailto:{{$member->email}}" style="font-size: 1.3em; color: blue;" target="_blank"><i class="fas fa-envelope"></i></a></th>
                                            <th scope="col" class="text-center"><a href="#" style="font-size: 1.3em; color: blue;"><i class="fas fa-phone-square"></i></a></th>
                                        @endnotmobile

                                        @if ($community->user_id==Auth::id())
                                            <td>|</td>
                                            <td><a href="/communitymember/{{$member->id}}/edit?cmid={{$community->id}}" style="font-size: 1.3em; color: #800080;"><i class="fas fa-user-edit"></i></a></td>
                                            <td><a href="#" style="font-size: 1.3em; color: red;"><i data-member-id="{{$member->id}}"id="deleteMember" alt="Delete" title="Delete" class="fas fa-minus-circle"></i><a></td>
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

