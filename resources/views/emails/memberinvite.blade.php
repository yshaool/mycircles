Hello {{$communityMember->name}},<br>
User {{$communityOwner->name}} has started a community for {{$community->name}}.<br>
You are invited to join the community.<br>
After joining you will be able to view members contact details from anywhere.<br>
To join the please click - <a href="{{env('APP_URL')}}joinfromemail?code={{$communityMember->invite_code}}">join the community {{$community->name}}</a><br>
or use invitation code {{$communityMember->invite_code}} at the myCircles page using the button "Join A Circle".<br>
<br>
Thank you<br>
MyCircles Team<br>
