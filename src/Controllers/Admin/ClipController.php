<?php

namespace Xmen\StarterKit\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use function Xmen\StarterKit\Helpers\logAdmin;

use function Xmen\StarterKit\Helpers\logAdminBatch;
use Xmen\StarterKit\Models\Clip;
use Xmen\StarterKit\Requests\ClipSaveRequest;
use Illuminate\Support\Facades\Storage;

class ClipController extends Controller
{
    public function bulk(Request $request)
    {
        switch ($request->input('bulk')) {
            case 'delete':
                $msg = __('Clip deleted successfully');
                logAdminBatch(__METHOD__ . '.' . $request->input('bulk'), Clip::class, $request->input('id'));
                Clip::destroy($request->input('id'));

                break;
            case 'inactive':
                $msg = __('Clip deactivated successfully');
                logAdminBatch(__METHOD__ . '.' . $request->input('bulk'), Clip::class, $request->input('id'));
                Clip::whereIn('id', $request->input('id'))->update(['active' => 0]);

                break;
            case 'active':
                $msg = __('Clip activated successfully');
                logAdminBatch(__METHOD__ . '.' . $request->input('bulk'), Clip::class, $request->input('id'));
                Clip::whereIn('id', $request->input('id'))->update(['active' => 1]);

                break;
            default:
                $msg = __('Unknown bulk action :' . $request->input('bulk'));
        }

        return redirect()->route('admin.clip.index')->with(['message' => $msg]);
    }

    public function createOrUpdate(Clip $clip, ClipSaveRequest $request)
    {
        $clip->title = $request->input('title');
        $clip->slug = \StarterKit::slug($request->input('title'));
        $clip->body = $request->input('body');
        $clip->active = $request->has('active');
        $clip->user_id = auth()->id();
        if ($request->hasFile('clip')) {
            $name = $clip->slug . '.' . request()->clip->getClientOriginalExtension();
            $clip->file = $name;
            $request->file('clip')->storeAs('public/clips', $name);
        }
        if ($request->hasFile('cover')) {
            $name = $clip->slug . '.' . request()->cover->getClientOriginalExtension();
            $clip->cover = $name;
            $request->file('cover')->storeAs('public/clips', $name);
        }

        $clip->save();
        $clip->retag(explode(',', $request->input('tags')));

        return $clip;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $n = Clip::latest();
        if ($request->has('filter')) {
            $n = $n->where('active', $request->filter);
        }
        $clips = $n->paginate(10);

        return view('starter-kit::admin.clip.clipList', compact('clips'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('starter-kit::admin.clip.clipForm');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClipSaveRequest $request)
    {
        $clip = new Clip();
        $clip = $this->createOrUpdate($clip, $request);
        logAdmin(__METHOD__, Clip::class, $clip->id);

        return redirect()->route('admin.clip.edit', $clip->slug)->with(['message' => $clip->title . ' ' . __('created successfully')]);
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
    public function edit(Clip $clip)
    {
        return view('starter-kit::admin.clip.clipForm', compact('clip'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClipSaveRequest $request, Clip $clip)
    {
        $clip = $this->createOrUpdate($clip, $request);

        logAdmin(__METHOD__, Clip::class, $clip->id);

        return redirect()->route('admin.clip.edit', $clip->slug)->with(['message' => $clip->title . ' ' . __('created successfully')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Clip $clip)
    {
        logAdmin(__METHOD__, Clip::class, $clip->id);
        Storage::delete($clip->file);
        Storage::delete($clip->cover);
        $clip->delete();

        return redirect()->back()->with(['message' => __('Clip deleted successfully')]);
    }
}
