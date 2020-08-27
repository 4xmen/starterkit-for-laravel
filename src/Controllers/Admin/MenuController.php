<?php

namespace Xmen\StarterKit\Controllers\Admin;

use Xmen\StarterKit\Models\Category;
use App\Http\Controllers\Controller;
use Xmen\StarterKit\Requests\MenuSaveRequest;
use Xmen\StarterKit\Models\Menu;
use Illuminate\Http\Request;
use function Xmen\StarterKit\Helpers\logAdmin;

class MenuController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
        $menus = Menu::paginate(5);
        return view('admin.menu.menuList', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(MenuSaveRequest $request) {
        //
        $menu = new Menu();
        $menu->name = $request->input('name');
        $menu->user_id = auth()->id();
        $menu->save();
        logAdmin(__METHOD__, Menu::class, $menu->id);
        return redirect()->back()
            ->with(['message' => "Menu stored"]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu) {
        //
        return  view('admin.menu.menuShow',compact('menu'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu) {
        //
//        return $menu->menuItems()->whereNull('parent')->orderBy('sort')->get();
        $cats = Category::all();
        return view('admin.menu.menuForm', compact('menu', 'cats'));
    }

    public function save(Menu $menu, $arr, $parent = null) {

        foreach ($arr as $k => $a) {
            $tmp = $a;
            $tmp['sort'] = $k;
            if (!isset($tmp['menuabletype']) || $tmp['menuabletype'] == ''){
                $tmp['menuable_type'] = null;
                $tmp['menuable_id'] = null;
                unset($tmp['menuabletype'],$tmp['menuableid']);
            }else{
                $tmp['menuable_type'] = $tmp['menuabletype'];
                $tmp['menuable_id'] = $tmp['menuableid'];
                unset($tmp['menuabletype'],$tmp['menuableid']);
            }
            $tmp['parent']  = $parent;
            $tmp['user_id']  = auth()->id() ;
            unset($tmp['can']);
            unset($tmp['id']);
            if (isset($tmp['children'])){
                unset($tmp['children']);
                $b = true;
            }else{
                $b = false;
            }
//            dd( json_encode($tmp) );
            $m = $menu->menuItems()->create(
                $tmp
            );
            if($b){
                $this->save($menu,$a['children'][0],$m->id);
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu) {
        //
        $request->validate([
            'info' => 'required|json'
        ]);

        $arr = json_decode($request->input('info'), true);
        $menu->menuItems()->delete();
        $this->save($menu,$arr[0]);
        logAdmin(__METHOD__, Menu::class, $menu->id);
        if ($request->ajax()){
            return  ["OK" => true, 'msg' => "Menu updated"];
        }
        return redirect()->back()
            ->with(['message' => "Menu updated"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu) {
        //
        $menu->delete();
        logAdmin(__METHOD__, MenuSaveRequest::class, $menu->id);
        return redirect()->back()
            ->with(['message' => "Menu deleted."]);
    }
}
