Hello {{$communityMember->name}},
User {{$communityOwner->name}} has started a community for {{$community->name}}.
You are invited to join the community.
After joining you will be able to view members contact details from anywhere.
To join the please click the
{{env('APP_URL')}}communities/{{$community->id}}/join?code={{$communityMember->invite_code}}
or use invitation code {{$communityMember->invite_code}} at the myCircles page using the button "Join A Circle".

Thank you
MyCircles Team
