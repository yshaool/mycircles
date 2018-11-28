@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                   Edit My Profile
                   <a href="/users/{{$user->id}}" role="button" class="btn btn-secondary btn-sm float-right">back</a>
                </div>
                <div class="card-body">
                    <form action="{{ action('UserController@update', ['id' => $user->id]) }}" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="container" class="float-left">
                            <div class="row" style="max-width:450px;">
                                <div class="col-sm">
                                    Email (username):
                                </div>
                                <div class="col-sm">
                                    {{$user->email}}
                                </div>
                                <div class="col-sm">
                                    <a href="/users/{{$user->id}}/editusername">Change Email</a>
                                </div>
                            </div>
                            <div class="row" style="max-width:450px;">
                                <div class="col-sm">
                                    Password:
                                </div>
                                <div class="col-sm">
                                    **********
                                </div>
                                <div class="col-sm">
                                    <a href="/users/{{$user->id}}/editpassword">Change Password</a>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="name" class="col-form-label">Name</label>
                            <input type="text" class="form-control col-sm-6" id="name" placeholder="Name" name="name" value="{{ old('name', $user->name ?? $user->name ?? '') }}" />
                        </div>
                        <div class="form-group">
                                <label for="phone" class="col-form-label">Phone</label>
                                <input type="text" class="form-control col-sm-6" id="phone" placeholder="Phone" name="phone" value="{{ old('phone', $user->phone ?? $user->phone ?? '') }}" />
                        </div>
                        <div class="form-group">
                                <label for="address" class="col-form-label">Address</label>
                                <textarea class="form-control col-sm-6" id="address" placeholder="Home address" name="address" />{{ old('address', $user->address ?? $user->address ?? null) }}</textarea>
                        </div>
                        <div class="form-group">
                                <label for="profession" class="col-form-label">Profession</label>
                                <input type="text" class="form-control col-sm-6" id="profession" placeholder="Profession" name="profession" value="{{ old('profession', $user->profession ?? $user->profession ?? '') }}" />
                         </div>
                        <div class="form-group">
                                <label for="services" class="col-form-label">Provide Services (Separate with Comma)</label>
                                <textarea class="form-control col-sm-6" id="services" placeholder="services" name="services" />{{ old('services', $user->services ?? $user->services ?? null) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" class="form-control-file" id="image" name="image">
                        </div>
                        <input type="hidden" name="_method" value="PUT">
                        <input type="submit" value="Update" class="btn btn-primary" />
                    </form>
                    <br><br>
                    <div class="container">
                            @if ($user->image!="")
                            <div><b>Current Image</b> (to keep it leave image field empty)</div>
                            <br>
                            <img src="{{ asset('storage/users/'.$user->image) }}"  alt="{{$user->name}}" class="rounded">
                            @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

</script>

@endsection
