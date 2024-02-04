<?php

namespace Xmen\StarterKit\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use function Xmen\StarterKit\Helpers\logAdmin;
use function Xmen\StarterKit\Helpers\logAdminBatch;
use Xmen\StarterKit\Models\Comment;

class CommentController extends Controller
{
    public function bulk(Request $request)
    {
        switch ($request->input('bulk')) {
            case 'delete':
                $msg = __('Comments deleted successfully');
                logAdminBatch(__METHOD__ . '.' . $request->input('bulk'), Comment::class, $request->input('id'));
                Comment::destroy($request->input('id'));

                break;
            case 'pending':
                $msg = __('Comments pending successfully');
                logAdminBatch(__METHOD__ . '.' . $request->input('bulk'), Comment::class, $request->input('id'));
                Comment::whereIn('id', $request->input('id'))->update(['status' => 0]);

                break;
            case 'approve':
                $msg = __('Comments approved successfully');
                logAdminBatch(__METHOD__ . '.' . $request->input('bulk'), Comment::class, $request->input('id'));
                Comment::whereIn('id', $request->input('id'))->update(['status' => 1]);

                break;
            case 'reject':
                $msg = __('Comments rejected successfully');
                logAdminBatch(__METHOD__ . '.' . $request->input('bulk'), Comment::class, $request->input('id'));
                Comment::whereIn('id', $request->input('id'))->update(['status' => -1]);

                break;
            default:
                $msg = __('Unknown bulk action :' . $request->input('bulk'));
        }

        return redirect()->route('admin.comment.index')->with(['message' => $msg]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $comment = Comment::latest();
        if ($request->has('filter')) {
            $comment = $comment->where('status', $request->filter);
        }
        $comments = $comment->paginate(20);

        return view('starter-kit::admin.comments', compact('comments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function status(Comment $comment, $status)
    {
        logAdmin(__METHOD__ . '.' . $status, Comment::class, $comment->id);
        $comment->status = $status;
        $comment->save();

        return redirect()->back()->with(['message' => _("Comment status changed")]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        logAdmin(__METHOD__, Comment::class, $comment->id);
        $comment->delete();

        return redirect()->route('admin.comment.index')->with(['message' => __('Comment deleted successfully')]);
    }
}
