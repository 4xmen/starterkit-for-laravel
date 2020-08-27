<?php

namespace Xmen\StarterKit\Controllers\Admin;

use Xmen\StarterKit\Models\Gallery;
use App\Http\Controllers\Controller;
use Xmen\StarterKit\Models\Image;
use Illuminate\Http\Request;
use function Xmen\StarterKit\Helpers\logAdmin;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Gallery $gallery)
    {
        //
        $img = $request->file('image');

        foreach ($request->input('title') as $k => $item) {
            $newimage = $gallery->images()->create([
                'title'=> $item,
                'user_id' => auth()->id(),
            ]);
            $newimage->addMedia($img[$k])->toMediaCollection();
        }
        logAdmin(__METHOD__,Gallery::class,$gallery->id);
        return redirect()->route('admin.gallery.edit',$gallery->slug)->with(['message' =>  count($request->input('title')) . ' ' . __('images uploaded successfully')]);

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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        //
        logAdmin(__METHOD__,Image::class,$image->id);
        $image->delete();
        return  redirect()->back()->with(['message' =>  __('image deleted successfully')]);
    }
}
