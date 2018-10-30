@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    My Circles
                    <a href="communities/create" role="button" class="btn btn-primary btn-sm float-right">Create Circle</a>
                    <button type="button" class="btn btn-secondary btn-sm float-right mr-1">Join Circle</button>
                </div>

                <div class="card-body">
                    @foreach ($user->communities as $community)
                        {{$community->name}}
                    @endforeach




                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @php
                    //print_r($user->communities);
                    //{{ asset('storage/circles/test-circle_1540856445.jpg') }}
                    @endphp

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

