<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Jobs\MailSenderJob;
use App\Mail\NewFeedback;
use App\Models\Feedback;
use App\Rules\RestrictedFiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class FeedbachController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(Request $request)
    {
        return view('client.feedback.index', ['FeedbackClass' => Feedback::class]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Feedback::class);

        $data = $request->validate([
            'subject' => 'required|max:255',
            'message' => 'required|max:1000',
            'attachment' =>  ['nullable', new RestrictedFiles, 'max:3072'],
        ]);

        $feed = new Feedback();

        $feed->subject = $data['subject'];
        $feed->message = $data['message'];
        $feed->user_id = auth()->user()->id;
        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('attachments', 'public');
            $feed->attachment = $path;
        }

        $feed->save();
        MailSenderJob::dispatch(config('mail.admin.email'), new NewFeedback($feed));

        return back()->with('success', 'Your feedback have been sent, you will receive an email once it is processed !');;
    }

}
