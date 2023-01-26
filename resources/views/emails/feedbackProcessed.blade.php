<div class="container">

    <h2>Hello {{$feedback->user->name}}</h2>
    <h3>We have recieved your feedback, and it is now in processing:</h3>

    <div class="h3">Subject: <span style="font-weight: normal">{{$feedback->subject}}</span></div>
    <p>{{$feedback->message}}</p>

    <p>Have a nice day.</p>
    <p>admin</p>

    @if($file != null)
        <a href="{{route('wellcome').$file}}">Attached file</a>
    @endif

</div>
