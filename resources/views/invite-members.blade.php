@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{$community->name}}
                    <a href="/communities/{{$community->id}}" role="button" class="btn btn-secondary btn-sm float-right">back</a>
                </div>
                <div class="card-body">
                    <div class="container mt-4">
                        <h4>Choose Members to Invite:</h4>
                        <div class="container mb-3"><a href="#"><span id="checkall">Check All</span></a>  <span style="margin-left:30px;">(Number of Invites Sent)</span></div>
                        <div class="container">
                            <form action="{{ action('CommunityController@inviteMembers', ['id' => $community->id]) }}" method="post" accept-charset="utf-8">
                            {{ csrf_field() }}
                            <div class="row">
                            @foreach ($community->communityMembers as $member)
                                @if ($loop->index!=0 && $loop->index % 3 ==0)
                                </div><div class="row mb-4">
                                @endif
                                    <div class="col-sm">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="{{$member->id}}" id="memeberstoinvite[]" name="memeberstoinvite[]">
                                            <label class="form-check-label" for="defaultCheck1">{{$member->name}} ({{$member->invites}})</label>
                                        </div>
                                    </div>
                            @endforeach
                            </div>
                            <input type="hidden" name="community_id" value="{{$community->id}}">
                            <input type="submit" value="Send Invitation Emails" class="btn btn-primary" />
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


