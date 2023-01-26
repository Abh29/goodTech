@extends('layouts.app')

@section('css')
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">


            <div class="card p-0">
                <div class="card-header">
                    <div class="row">
                        <div class="col-1 justify-content-center text-center">User id</div>
                        <div class="col-2 justify-content-center text-center">User creation time</div>
                        <div class="col-2 justify-content-center text-center">Feedback creation time</div>
                        <div class="col-1 justify-content-center text-center">Username</div>
                        <div class="col-2 justify-content-center text-center">Email</div>
                        <div class="col-3 justify-content-center text-center">Subject</div>
                        <div class="col-1"></div>
                    </div>
                </div>

                <div class="card-body pe-0 ps-0">

                    @foreach($feedbacks as $feed)
                        <div class="accordion accordion-flush" id="accordionFlushExample">
                            <div class="accordion-item">
                                <div class="row accordion-header ms-0 me-0">
                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            @if($feed->user == null) {{dd($feed)}} @endif
                                            <td class="col-1 text-center">{{$feed->user_id}}</td>
                                            <td class="col-2 text-center">{{$feed->user->created_at}}</td>
                                            <td class="col-2 text-center">{{$feed->created_at}}</td>
                                            <td class="col-1 text-center">{{$feed->user->name}}</td>
                                            <td class="col-2 text-center">{{$feed->user->email}}</td>
                                            <td class="col-3 text-center">{{$feed->subject}}</td>
                                            <td class="col-1">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="{{'#flush-collapse' . $feed->id}}" aria-expanded="false" aria-controls="flush-collapseOne"></button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div id="{{'flush-collapse' . $feed->id}}" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body row">
                                        <div class="col-9 offset-1">
                                            <div class="col-12">
                                                {{$feed->message}}
                                            </div>
                                            @if($feed->attachment)
                                                <div class="col-12 pb-5">
                                                    <a href="{{Storage::url($feed->attachment)}}">Attached file</a>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-2">
                                            <div class="col-12 pb-1">
                                                @can('process', $feed)
                                                    <form action="{{route('admin.feedbacks.process', $feed->id)}}" method="post">
                                                        @csrf
                                                        <input type="submit" class="btn btn-info" value="Process">
                                                    </form>
                                                @else
                                                    <button class="btn btn-success disabled">Processed</button>
                                                @endcan
                                            </div>
                                            <div class="col-12 pb-5">
                                                <form action="{{route('admin.feedbacks.delete', $feed->id)}}", method="post">
                                                    @csrf
                                                    <input type="submit" class="btn btn-danger" value="Delete">
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    </div>

                <div class="card-footer">
                    <div class="row">
                        {{$feedbacks->links('partials.pagination')}}
                    </div>
                </div>
            </div>





        </div>
    </div>
@endsection
