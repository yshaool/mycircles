@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                   Update Password for {{$user->name}}
                   <a href="/users/{{$user->id}}/edit" role="button" class="btn btn-secondary btn-sm float-right">back</a>
                </div>
                <div class="card-body">
                    <form action="{{ action('UserController@updatePassword', ['id' => $user->id]) }}" method="post" id="updatePassForm" accept-charset="utf-8">
                        {{ csrf_field() }}
                        If you don't have your current password you can logout and click the forgot my password link in the login page.
                        <br>
                        <div class="form-group">
                            <label for="password" class="col-form-label">Current Password </label>
                            <input type="password" class="form-control col-sm-6" id="password" placeholder="Password" name="password" value="" />
                        </div>

                        <div class="form-group">
                            <label for="New password" class="col-form-label">New Password </label>
                            <input type="password" class="form-control col-sm-6" id="newpassword" placeholder="New Password" name="newpassword" value="" />
                        </div>

                        <div class="form-group">
                            <label for="newpasswordagain" class="col-form-label">Re-enter new Password </label>
                            <input type="password" class="form-control col-sm-6" id="newpasswordagain" placeholder="Renter New Password" name="newpasswordagain" value="" />
                        </div>

                        <input type="hidden" name="_method" value="PUT">
                        <input type="submit" value="Update" class="btn btn-primary" />
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
