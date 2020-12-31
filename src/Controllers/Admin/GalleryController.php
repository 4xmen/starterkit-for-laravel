<?php

namespace Xmen\StarterKit\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Xmen\StarterKit\Models\Image;
use function Xmen\StarterKit\Helpers\logAdmin;

use function Xmen\StarterKit\Helpers\logAdminBatch;
use Xmen\StarterKit\Models\Gallery;
use Xmen\StarterKit\Requests\GallerySaveRequest;

class GalleryController extends Controller
{
    public function bulk(Request $request)
    {
        switch ($request->input('bulk')) {
            case 'delete':
                $msg = __('Gallery deleted successfully');
                logAdminBatch(__METHOD__ . '.' . $request->input('bulk'), Gallery::class, $request->input('id'));
                Gallery::destroy($request->input('id'));

                break;
            case 'draft':
                $msg = __('Gallery drafted successfully');
                logAdminBatch(__METHOD__ . '.' . $request->input('bulk'), Gallery::class, $request->input('id'));
                Gallery::whereIn('id', $request->input('id'))->update(['status' => 0]);

                break;
            case 'publish':
                $msg = __('Gallery published successfully');
                logAdminBatch(__METHOD__ . '.' . $request->input('bulk'), Gallery::class, $request->input('id'));
                Gallery::whereIn('id', $request->input('id'))->update(['status' => 1]);

                break;
            default:
                $msg = __('Unknown bulk action :' . $request->input('bulk'));
        }

        return redirect()->route('admin.gallery.all')->with(['message' => $msg]);
    }


    public function updatetitle(\Illuminate\Http\Request $request){
      foreach ($request->titles as $k => $title) {
            $image = Image::whereId($k)->first();
            $image->title = $title;
            $image->save();
        }
        return redirect()->back()->with(['message' => __("Titles updated")]);
    }
    public function createOrUpdate(Gallery $gallery, GallerySaveRequest $request)
    {
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

    public function index(Request $request)
    {
        $n = Gallery::latest();
        if ($request->has('filter')) {
            $n = $n->where('status', $request->filter);
        }
        $galleries = $n->paginate(10);

        return view('starter-kit::admin.gallery.galleryIndex', compact('galleries'));
    }

    public function create()
    {
        return view('starter-kit::admin.gallery.galleryForm');
    }

    public function store(GallerySaveRequest $request)
    {
        $gallery = new Gallery();
        $gallery = $this->createOrUpdate($gallery, $request);
        logAdmin(__METHOD__, Gallery::class, $gallery->id);

        return redirect()->route('admin.gallery.edit', $gallery->slug)->with(['message' => $gallery->title . ' ' . __('created successfully')]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Gallery $gallery)
    {
    }

    public function edit(Gallery $gallery)
    {
        return view('starter-kit::admin.gallery.galleryForm', compact('gallery'));
    }

    public function update(GallerySaveRequest $request, Gallery $gallery)
    {
        $this->createOrUpdate($gallery, $request);
        logAdmin(__METHOD__, Gallery::class, $gallery->id);

        return redirect()->route('admin.gallery.edit', $gallery->slug)->with(['message' => $gallery->title . ' ' . __('updated successfully')]);
    }

    public function destroy(Gallery $gallery)
    {
        $gallery->images()->delete();
        logAdmin(__METHOD__, Gallery::class, $gallery->id);
        $gallery->delete();

        return redirect()->route('admin.gallery.all')->with(['message' => $gallery->title . ' ' . __(' deleted successfully')]);
    }
}
