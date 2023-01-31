@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Add a Feedback') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('user.feedbacks.create') }}" enctype="multipart/form-data">
                            @csrf

                            @if (session('success'))
                                <div class="row mb-1">
                                    <div class="col-md-10 offset-md-1">
                                        <div class="alert alert-success" role="alert">
                                            {{ session('success') }}
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @cannot('create', $FeedbackClass)
                                <div class="row mb-3">
                                    <div class="col-md-10 offset-md-1">
                                        <div class="alert alert-danger" role="alert">
                                            {{__('You cannot create a new feedback, you have reached the limit for today!')}}
                                        </div>
                                    </div>
                                </div>
                            @endcannot

                            <div class="row mb-3">
                                <div class="col-md-10 offset-md-1">
                                    <input id="subject" type="text" class="form-control @error('subject') is-invalid @enderror" name="subject"
                                           value="{{ old('subject') }}" placeholder="{{ __('Subject') }}" required autocomplete="subject" autofocus>
                                    @error('subject')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-10 offset-md-1">
                                    <textarea id="message" name="message" class=" form-control @error('message') is-invalid @enderror "
                                              placeholder="{{__('Message')}}"
                                              required autofocus maxlength="1000" rows="6">{{ old('message') }}</textarea>
                                    @error('message')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-10 offset-md-1">
                                    <input type="file" id="file-input" name="attachment" class="form-control @error('attachment') is-invalid @enderror">
                                    @error('attachment')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary @cannot('create', $FeedbackClass) disabled @endcannot">
                                        {{ __('Send a Feedback') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
