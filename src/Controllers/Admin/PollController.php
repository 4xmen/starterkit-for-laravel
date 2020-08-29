<?php

namespace Xmen\StarterKit\Controllers\Admin;

use App\Http\Controllers\Controller;
use Xmen\StarterKit\Requests\PollSaveRequest;
use Xmen\StarterKit\Models\Opinion;
use Xmen\StarterKit\Models\Poll;

use Illuminate\Http\Request;
use function Xmen\StarterKit\Helpers\logAdmin;
use function Xmen\StarterKit\Helpers\logAdminBatch;

class PollController extends Controller {


    public function bulk(Request $request) {

        switch ($request->input('bulk')) {
            case 'delete':
                $msg = __('Poll deleted successfully');
                logAdminBatch(__METHOD__ . '.' . $request->input('bulk'), Poll::class, $request->input('id'));
                Poll::destroy($request->input('id'));
                break;
            case 'inactive':
                $msg = __('Poll deactivated successfully');
                logAdminBatch(__METHOD__ . '.' . $request->input('bulk'), Poll::class, $request->input('id'));
                Poll::whereIn('id', $request->input('id'))->update(['active' => 0]);
                break;
            case 'active':
                $msg = __('Poll activated successfully');
                logAdminBatch(__METHOD__ . '.' . $request->input('bulk'), Poll::class, $request->input('id'));
                Poll::whereIn('id', $request->input('id'))->update(['active' => 1]);
                break;
            default:
                $msg = __('Unknown bulk action :' . $request->input('bulk'));
        }
        return redirect()->route('admin.poll.index')->with(['message' => $msg]);
    }

    public function createOrUpdate(Poll $poll, PollSaveRequest $request) {
        $poll->title = $request->input('title');
        $poll->slug = \StarterKit::slug($request->input('title'));
        $poll->body = $request->input('body');
        $poll->active = $request->has('active');
        $poll->user_id = auth()->id();
        $poll->save();
        return $poll;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
    //
    $n = Poll::latest();
    if ($request->has('filter')) {
        $n = $n->where('active', $request->filter);
    }
    $polls = $n->paginate(10);
    return view('starter-kit::admin.poll.pollList', compact('polls'));
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
        return view('starter-kit::admin.poll.pollForm');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(PollSaveRequest $request) {
        //
        $poll = new Poll();
        $poll = $this->createOrUpdate($poll, $request);
        if ($request->has('options'))
        foreach ($request->input('options') as $op) {
            $poll->opinions()->create([
                    'title' => $op
                ]
            );
        }
        logAdmin(__METHOD__, Poll::class, $poll->id);
        return redirect()->route('admin.poll.edit', $poll->slug)->with(['message' => $poll->title . ' ' . __('created successfully')]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Poll $poll) {
        //
        return  view('starter-kit::admin.poll.pollForm',compact('poll'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(PollSaveRequest $request, Poll $poll) {
        //
        $poll = $this->createOrUpdate($poll, $request);
        if ($request->has('options'))
        foreach ($request->input('options') as $op) {
            $poll->opinions()->create([
                    'title' => $op
                ]
            );
        }
        if ($request->has('oldop'))
        foreach ($request->input('oldop') as $k => $op) {
            if (empty($op)){
                Opinion::whereId($k)->delete();
            }else{
                Opinion::whereId($k)->update(
                    [
                        'title' => $op
                    ]
                );
            }
        }

        logAdmin(__METHOD__, Poll::class, $poll->id);
        return redirect()->route('admin.poll.edit', $poll->slug)->with(['message' => $poll->title . ' ' . __('created successfully')]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Poll $poll) {
        //
        logAdmin(__METHOD__,Poll::class,$poll->id);
        $poll->delete();
        return  redirect()->back()->with(['message' =>  __('Poll deleted successfully')]);
    }
}
