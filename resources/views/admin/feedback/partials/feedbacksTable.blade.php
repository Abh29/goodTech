<div class="container">
    <div class="row justify-content-center">

        @php
            $currentUrl = url()->current() . '?perPage=' . $perPage;
            $currentUrl2 = url()->current() . '?order=' . $order . '&desc=' . $desc;
        @endphp

        <table-header-sorter></table-header-sorter>

        <div class="card p-0">
            <div class="card-header">
                <div class="row">
                    <div class="col-1 justify-content-center text-center"><a href="{{$currentUrl . '&order=1'}}@if($order == 1) &desc={{!$desc}} @else &desc=0 @endif">{{_('User id')}}</a></div>
                    <div class="col-2 justify-content-center text-center"><a href="{{$currentUrl . '&order=2'}}@if($order == 2) &desc={{!$desc}} @else &desc=0 @endif">{{_('User creation time')}}</a></div>
                    <div class="col-2 justify-content-center text-center"><a href="{{$currentUrl . '&order=3'}}@if($order == 3) &desc={{!$desc}} @else &desc=0 @endif">{{_('Feedback creation time')}}</a></div>
                    <div class="col-1 justify-content-center text-center"><a href="{{$currentUrl . '&order=4'}}@if($order == 4) &desc={{!$desc}} @else &desc=0 @endif">{{_('Username')}}</a></div>
                    <div class="col-2 justify-content-center text-center"><a href="{{$currentUrl . '&order=5'}}@if($order == 5) &desc={{!$desc}} @else &desc=0 @endif">{{_('Email')}}</a></div>
                    <div class="col-3 justify-content-center text-center">{{_('Subject')}}</div>
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
                                        <td class="col-2 text-center">{{$feed->user_created_at}}</td>
                                        <td class="col-2 text-center">{{$feed->created_at}}</td>
                                        <td class="col-1 text-center">{{$feed->username}}</td>
                                        <td class="col-2 text-center">{{$feed->email}}</td>
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
                    <div class="col-8">
                        <div>
                            {{$feedbacks->appends(compact(['perPage', 'order', 'desc']))->links('pagination::bootstrap-4')}}
                        </div>
                    </div>
                    <div class="col-1">
                        <label>Per-page: </label>
                    </div>
                    <div class="col-3">
                        <form id="perPage-form" class="form-inline" method="GET" role="form" action="">
                            <div class="form-group">
                                <select class="form-control" id="perPage-select" name="perPage" current="{{$currentUrl2}}">
                                    <option value="10" @if($perPage == 10) selected @endif >10</option>
                                    <option value="50" @if($perPage == 50) selected @endif >50</option>
                                    <option value="100" @if($perPage == 100) selected @endif >100</option>
                                </select>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
