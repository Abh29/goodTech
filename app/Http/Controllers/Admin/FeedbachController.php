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
     */
    public function index(Request $request)
    {
        $perPage = $request->perPage ?? 10;
        $orderQ = $request->order ?? 1;
        $desc = $request->desc ?? 0;
        $direction = $desc == 1? 'desc' : 'asc';
        $column = '';

        switch ($orderQ) {
            case 1:
                $column = 'user_id';
                break;
            case 2:
                $column = 'user_created_at';
                break;
            case 3:
               $column = 'created_at';
                break;
            case 4:
                $column = 'username';
                break;
            case 5:
                $column = 'email';
                break;
        }

        $feeds = Feedback::leftjoin('users', 'users.id', '=', 'feedback.user_id')
            ->select([
                'feedback.*',
                'users.email as email',
                'users.name as username',
                'users.created_at as user_created_at',
            ])->orderby($column, $direction)->paginate($perPage);


        if ($request->ajax())
            return view('admin.feedback.partials.feedbacksTable', [
                'feedbacks' => $feeds,
                'perPage' => $perPage,
                'order' => $orderQ,
                'desc' => $desc,
            ])->render();

        return view('admin.feedback.index', [
            'feedbacks' => $feeds,
            'perPage' => $perPage,
            'order' => $orderQ,
            'desc' => $desc,
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
        $feed = Feedback::findOrFail($id);

        $this->authorize('process', [Feedback::class, $feed]);

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
        $this->authorize('delete', Feedback::class);
        Feedback::destroy($id);
        return back();
    }
}
