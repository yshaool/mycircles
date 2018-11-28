@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                   Update Username
                   <a href="/users/{{$user->id}}/edit" role="button" class="btn btn-secondary btn-sm float-right">back</a>
                </div>
                <div class="card-body">
                    <form action="{{ action('UserController@updateUsername', ['id' => $user->id]) }}" method="post" accept-charset="utf-8">
                        {{ csrf_field() }}
                        <br>
                        <div class="form-group">
                            <label for="email" class="col-form-label">Email (Username)</label>
                            <input type="text" class="form-control col-sm-6" id="email" placeholder="Email (username)" name="email" value="{{ old('email', $user->email ?? $user->email ?? '') }}" />
                        </div>

                        <input type="hidden" name="_method" value="PUT">
                        <input type="submit" value="Update" class="btn btn-primary" />
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

</script>

@endsection
