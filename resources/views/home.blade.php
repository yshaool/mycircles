@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    My Circles
                    <a href="communities/create" role="button" class="btn btn-primary btn-sm float-right">Create Circle</a>
                    <a href="/joincircle" role="button" class="btn btn-secondary btn-sm float-right mr-1">Join A Circle</a>
                </div>

                <div class="card-body">
                    <div class="container">
                        <div class="row mb-4">
                        @if (isset($user->communities))
                        @foreach ($user->communities as $community)
                            @if ($loop->index!=0 && $loop->index % 3 ==0)
                            </div><div class="row mb-4">
                            @endif
                            <div class="col text-center">
                                <a href="/communities/{{$community->id}}"><img src="{{ asset('storage/circles/'.$community->image) }}" alt="{{$community->name}}" width="300px;"></a>
                                <br>
                                <a href="/communities/{{$community->id}}">{{$community->name}}</a>
                            </div>
                        @endforeach
                        @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

