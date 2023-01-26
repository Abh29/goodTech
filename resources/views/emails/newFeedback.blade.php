<div class="container">

    <h2>There is a new feedback:</h2>

    <div class="h3">User: <span style="font-weight: normal">{{$feedback->user->name}}</span></div>
    <div class="h3">Email: <span style="font-weight: normal">{{$feedback->user->email}}</span></div>
    <div class="h3">Subject: <span style="font-weight: normal">{{$feedback->subject}}</span></div>
    <p>{{$feedback->message}}</p>

    @if($file != null)
        <a href="{{route('wellcome').$file}}">Attached file</a>
    @endif

</div>
