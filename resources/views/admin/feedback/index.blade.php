@extends('layouts.app')

@section('css')
@endsection

@section('content')
    <div id="feedbacks_data">
        @include('admin.feedback.partials.feedbacksTable');
    </div>
@endsection

@section('js')
    @vite('resources/js/feedbacks/admin_index.js')
@endsection
