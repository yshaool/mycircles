@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{$community->name}}
                </div>
                <div class="card-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm">
                                    <img src="{{ asset('storage/circles/'.$community->image) }}" alt="{{$community->name}}">
                            </div>
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
                                </tr>
                            </thead>
                                <tbody>
                                @foreach ($community->communityMembers as $member)
                                    <tr>
                                        <td>{{$member->name}}</td>
                                        <td>{{$member->email}}</td>
                                        <td>{{$member->phone}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

