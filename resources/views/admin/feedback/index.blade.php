@extends('layouts.app')

@section('css')
@endsection

@section('content')
    <div id="feedbacks_data">
        @include('admin.feedback.partials.feedbacksTable');
    </div>
@endsection

@section('js')
    <script>
        document.getElementById('perPage-select').onchange = function() {
            window.location = "{{$feedbacks->url(1)}}&perPage=" + this.value;
        };
    </script>
    @vite('resources/js/feedbacks/admin_index.js')
@endsection
