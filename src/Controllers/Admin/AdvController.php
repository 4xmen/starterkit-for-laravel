<?php

namespace Xmen\StarterKit\Controllers\Admin;

use Xmen\StarterKit\Models\Adv;
use App\Http\Controllers\Controller;
use Xmen\StarterKit\Requests\AdvSaveRequest;
use StarterKit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use function Xmen\StarterKit\Helpers\logAdmin;
use function Xmen\StarterKit\Helpers\logAdminBatch;

class AdvController extends Controller
{

    public function bulk(Request $request)
    {

        switch ($request->input('bulk')) {
            case 'delete':
                $msg = __('Adv deleted successfully');
                logAdminBatch(__METHOD__ . '.' . $request->input('bulk'), Adv::class, $request->input('id'));
                Adv::destroy($request->input('id'));
                break;
            case 'inactive':
                $msg = __('Adv deactivated successfully');
                logAdminBatch(__METHOD__ . '.' . $request->input('bulk'), Adv::class, $request->input('id'));
                Adv::whereIn('id', $request->input('id'))->update(['active' => 0]);
                break;
            case 'active':
                $msg = __('Adv activated successfully');
                logAdminBatch(__METHOD__ . '.' . $request->input('bulk'), Adv::class, $request->input('id'));
                Adv::whereIn('id', $request->input('id'))->update(['active' => 1]);
                break;
            default:
                $msg = __('Unknown bulk action :' . $request->input('bulk'));
        }
        return redirect()->route('admin.adv.index')->with(['message' => $msg]);
    }

    public function createOrUpdate(Adv $adv, AdvSaveRequest $request)
    {
        $adv->title = $request->input('title');
        $adv->max_click = $request->input('max_click');
        $adv->link = $request->input('link');
        $adv->expire = Carbon::parse($request->input('expire'));
        $adv->active = $request->has('active');
        $adv->user_id = auth()->id();
        if ($request->hasFile('image')) {
            $name = StarterKit::Generate($adv->title) . '.' . request()->image->getClientOriginalExtension();
            $adv->image = $name;
            $request->file('image')->storeAs('public/advs', $name);
        }

        $adv->save();
        return $adv;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $n = Adv::latest();
        if ($request->has('filter')) {
            $n = $n->where('active', $request->filter);
        }
        $advs = $n->paginate(10);
        return view('starter-kit::admin.adv.advList', compact('advs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('starter-kit::admin.adv.advForm');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdvSaveRequest $request)
    {
        //
        $adv = new Adv();
        $adv = $this->createOrUpdate($adv, $request);
        logAdmin(__METHOD__, Adv::class, $adv->id);
        return redirect()->route('admin.adv.edit', $adv->id)->with(['message' => $adv->title . ' ' . __('created successfully')]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Adv $adv)
    {
        //
        return view('starter-kit::admin.adv.advForm', compact('adv'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdvSaveRequest $request, Adv $adv)
    {
        //

        $adv = $this->createOrUpdate($adv, $request);

        logAdmin(__METHOD__, Adv::class, $adv->id);
        return redirect()->route('admin.adv.edit', $adv->id)->with(['message' => $adv->title . ' ' . __('created successfully')]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Adv $adv)
    {
        //
        logAdmin(__METHOD__, Adv::class, $adv->id);
        $adv->delete();
        return redirect()->back()->with(['message' => __('Adv deleted successfully')]);
    }
}
