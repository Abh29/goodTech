<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\MailSenderJob;
use App\Mail\FeedbackProcessed;
use App\Mail\NewFeedback;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class FeedbachController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $perPage = $request->perPage ?? 10;
        $feeds = Feedback::orderBy('created_at', 'DESC')->paginate($perPage);

        if ($request->ajax())
            return view('admin.feedback.partials.feedbacksTable', [
                'feedbacks' => $feeds,
                'perPage' => $perPage,
            ])->render();

        return view('admin.feedback.index', [
            'feedbacks' => $feeds,
            'perPage' => $perPage,
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    public function process($id)
    {
        $feed = Feedback::find($id);
        if ($feed){
            $feed->processed = true;
            $feed->save();
            MailSenderJob::dispatch($feed->user->email, new FeedbackProcessed($feed))->delay(now()->addMinutes(1));
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Feedback::destroy($id);
        return back();
    }
}
