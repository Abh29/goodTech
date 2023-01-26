<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $feeds = Feedback::orderBy('created_at', 'DESC')->paginate(10);
        return view('admin.feedback.index', ['feedbacks' => $feeds]);
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
            Mail::to($feed->user->email)->send(new FeedbackProcessed($feed));
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
