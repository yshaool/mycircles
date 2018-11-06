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
                    <div class="container mt-4">
                        <h4>Choose Members to Invite:</h4>
                        <div class="container mb-3"><a href="#">Check All</a> | <a href="#">Check None</a></div>
                        <div class="container">
                            <div class="row">
                            @foreach ($community->communityMembers as $member)
                                @if ($loop->index!=0 && $loop->index % 3 ==0)
                                </div><div class="row mb-4">
                                @endif
                                    <div class="col-sm">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                            <label class="form-check-label" for="defaultCheck1">{{$member->name}}</label>
                                        </div>
                                    </div>
                            @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


