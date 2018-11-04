@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Joine Circle with Invitation Code
                </div>

                <div class="card-body">
                    <form action="{{ action('CommunityController@store') }}" method="post" accept-charset="utf-8">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="invite_code" class="col-form-label">Invitation Code</label>
                            <input type="text" class="form-control col-sm-6" id="invite_code" placeholder="Invitation Code" name="invite_code" value="" />
                        </div>
                        <input type="submit" value="Join" class="btn btn-primary" />

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

