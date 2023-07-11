<?php

namespace Xmen\StarterKit\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use function Xmen\StarterKit\Helpers\logAdmin;
use function Xmen\StarterKit\Helpers\logAdminBatch;
use Xmen\StarterKit\Models\Slider;
use Xmen\StarterKit\Requests\SliderSaveRequest;

class SliderController extends Controller
{
    public function bulk(Request $request)
    {
        switch ($request->input('bulk')) {
            case 'delete':
                $msg = __('Slider deleted successfully');
                logAdminBatch(__METHOD__ . '.' . $request->input('bulk'), Slider::class, $request->input('id'));
                Slider::destroy($request->input('id'));

                break;
            case 'inactive':
                $msg = __('Slider deactivated successfully');
                logAdminBatch(__METHOD__ . '.' . $request->input('bulk'), Slider::class, $request->input('id'));
                Slider::whereIn('id', $request->input('id'))->update(['active' => 0]);

                break;
            case 'active':
                $msg = __('Slider activated successfully');
                logAdminBatch(__METHOD__ . '.' . $request->input('bulk'), Slider::class, $request->input('id'));
                Slider::whereIn('id', $request->input('id'))->update(['active' => 1]);

                break;
            default:
                $msg = __('Unknown bulk action :' . $request->input('bulk'));
        }

        return redirect()->route('admin.slider.index')->with(['message' => $msg]);
    }

    public function createOrUpdate(Slider $slider, SliderSaveRequest $request)
    {
        $slider->body = $request->input('body','');
        $slider->active = $request->has('active');
        $slider->user_id = auth()->id();
        if ($request->hasFile('cover')) {
            $name = time().'.'.request()->cover->getClientOriginalExtension();
            $slider->image = $name;
            $request->file('cover')->storeAs('public/sliders', $name);
        }

        $slider->save();

        return $slider;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $n = Slider::latest();
        if ($request->has('filter')) {
            $n = $n->where('active', $request->filter);
        }
        $sliders = $n->paginate(10);

        return view('starter-kit::admin.slider.sliderList', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return  view('starter-kit::admin.slider.sliderForm');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SliderSaveRequest $request)
    {
        $slider = new Slider();
        $slider = $this->createOrUpdate($slider, $request);
        logAdmin(__METHOD__, Slider::class, $slider->id);

        return redirect()->route('admin.slider.edit', $slider->id)->with(['message' => $slider->title . ' ' . __('created successfully')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Slider $slider)
    {
        return  view('starter-kit::admin.slider.sliderForm', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SliderSaveRequest $request, Slider $slider)
    {
        $slider = $this->createOrUpdate($slider, $request);

        logAdmin(__METHOD__, Slider::class, $slider->id);

        return redirect()->route('admin.slider.edit', $slider->id)->with(['message' => $slider->title . ' ' . __('created successfully')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slider $slider)
    {
        logAdmin(__METHOD__, Slider::class, $slider->id);
        $slider->delete();

        return  redirect()->back()->with(['message' => __('Slider deleted successfully')]);
    }
}
