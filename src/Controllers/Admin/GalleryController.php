<?php

namespace Xmen\StarterKit\Controllers\Admin;

use Xmen\StarterKit\Models\Gallery;
use App\Http\Controllers\Controller;
use Xmen\StarterKit\Requests\GallerySaveRequest;

use Illuminate\Http\Request;
use function Xmen\StarterKit\Helpers\logAdmin;
use function Xmen\StarterKit\Helpers\logAdminBatch;

class GalleryController extends Controller
{

    public function bulk(Request $request) {

        switch ($request->input('bulk')) {
            case 'delete':
                $msg = __('Gallery deleted successfully');
                logAdminBatch(__METHOD__.'.'.$request->input('bulk'),Gallery::class,$request->input('id'));
                Gallery::destroy($request->input('id'));
                break;
            case 'draft':
                $msg = __('Gallery drafted successfully');
                logAdminBatch(__METHOD__.'.'.$request->input('bulk'),Gallery::class,$request->input('id'));
                Gallery::whereIn('id', $request->input('id'))->update(['status' => 0]);
                break;
            case 'publish':
                $msg = __('Gallery published successfully');
                logAdminBatch(__METHOD__.'.'.$request->input('bulk'),Gallery::class,$request->input('id'));
                Gallery::whereIn('id', $request->input('id'))->update(['status' => 1]);
                break;
            default:
                $msg = __('Unknown bulk action :' . $request->input('bulk'));
        }
        return redirect()->route('admin.gallery.all')->with(['message' => $msg]);
    }


    public function createOrUpdate(Gallery $gallery,GallerySaveRequest $request){
        $gallery->title = $request->input('title');
        $gallery->slug = \StarterKit::slug($request->input('title'));
        $gallery->description = $request->input('description');
        $gallery->status = $request->input('status');
        $gallery->user_id = auth()->id();

        $gallery->save();


        if ($request->hasFile('image')) {
            $gallery->media()->delete();
            $gallery->addMedia($request->file('image'))->toMediaCollection();
        }

        return $gallery;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $n = Gallery::latest();
        if ($request->has('filter')){
            $n = $n->where('status',$request->filter);
        }
        $galleries = $n->paginate(10);
        return view('starter-kit::admin.gallery.galleryIndex', compact('galleries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('starter-kit::admin.gallery.galleryForm');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GallerySaveRequest $request)
    {
        //
        $gallery = new Gallery();
        $gallery = $this->createOrUpdate($gallery, $request);
        logAdmin(__METHOD__,Gallery::class,$gallery->id);
        return redirect()->route('admin.gallery.edit',$gallery->slug)->with(['message' => $gallery->title . ' ' . __('created successfully')]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Gallery $gallery)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Gallery $gallery)
    {
        //
        return  view('starter-kit::admin.gallery.galleryForm',compact('gallery'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GallerySaveRequest $request, Gallery $gallery)
    {
        //
        $this->createOrUpdate($gallery, $request);
        logAdmin(__METHOD__,Gallery::class,$gallery->id);
        return redirect()->route('admin.gallery.edit',$gallery->slug)->with(['message' => $gallery->title . ' ' . __('updated successfully')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gallery $gallery)
    {
        //
        $gallery->images()->delete();
        logAdmin(__METHOD__,Gallery::class,$gallery->id);
        $gallery->delete();
        return redirect()->route('admin.gallery.all')->with(['message' => $gallery->title . ' ' . __(' deleted successfully')]);
    }
}
