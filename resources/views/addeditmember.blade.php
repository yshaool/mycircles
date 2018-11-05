@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Add Members to {{$community->name}}
                </div>

                <div class="card-body">
                    <form action="{{ action('CommunityController@addMemberFromForm') }}" method="post" accept-charset="utf-8">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="name" class="col-form-label">Member Name</label>
                            <input type="text" class="form-control col-sm-6" id="name" placeholder="Member Name" name="name" value="{{ old('name', request('name') ?? request('name') ?? null) }}" />
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-form-label">Email</label>
                            <input type="email" class="form-control col-sm-6" id="email" placeholder="email" name="email" value="{{ old('email', request('email') ?? request('email') ?? null) }}" />
                        </div>
                        <div class="form-group">
                            <label for="phone" class="col-form-label">Phone</label>
                            <input type="text" class="form-control col-sm-6" id="phone" placeholder="Member phone" name="phone" value="{{ old('phone', request('phone') ?? request('phone') ?? null) }}" />
                        </div>
                        <input type="hidden" name="community_member_id" value="0">
                        <input type="hidden" name="community_id" value="{{$community->id}}">
                        <input type="submit" value="Add Member" class="btn btn-primary" />

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

