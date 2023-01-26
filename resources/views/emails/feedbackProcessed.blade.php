<div class="container">

    <h2>We have recieved your feedback, and it is now in processing:</h2>

    <div class="h3">Subject: <span style="font-weight: normal">{{$feedback->subject}}</span></div>
    <p>{{$feedback->message}}</p>

    @if($file != null)
        <a href="{{route('wellcome').$file}}">Attached file</a>
    @endif

</div>
