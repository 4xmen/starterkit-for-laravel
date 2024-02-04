<?php

namespace Xmen\StarterKit\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use function Xmen\StarterKit\Helpers\logAdmin;
use Xmen\StarterKit\Models\Category;
use Xmen\StarterKit\Models\Menu;
use Xmen\StarterKit\Models\MenuItem;
use Xmen\StarterKit\Requests\MenuSaveRequest;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::paginate(5);

        return view('starter-kit::admin.menu.menuList', compact('menus'));
    }

    public function create()
    {
    }

    public function store(MenuSaveRequest $request)
    {
        $menu = new Menu();
        $menu->name = $request->input('name');
        $menu->user_id = auth()->id();
        $menu->save();
        logAdmin(__METHOD__, Menu::class, $menu->id);

        return redirect()->back()
            ->with(['message' => "Menu stored"]);
    }

    public function show(Menu $menu)
    {
        return view('starter-kit::admin.menu.menuShow', compact('menu'));
    }

    public function edit(Menu $menu)
    {
        $cats = Category::all();

        return view('starter-kit::admin.menu.menuForm', compact('menu', 'cats'));
    }

    public function save(Menu $menu, $arr, $parent = null)
    {
        foreach ($arr as $k => $a) {
            $tmp = $a;
            $tmp['sort'] = $k;
            if (!isset($tmp['menuabletype']) || $tmp['menuabletype'] == '') {
                $tmp['menuable_type'] = null;
                $tmp['menuable_id'] = null;
                unset($tmp['menuabletype'], $tmp['menuableid']);
            } else {
                $tmp['menuable_type'] = $tmp['menuabletype'];
                $tmp['menuable_id'] = $tmp['menuableid'];
                unset($tmp['menuabletype'], $tmp['menuableid']);
            }
            $tmp['parent'] = $parent;
            $tmp['user_id'] = auth()->id();
            unset($tmp['can']);
            unset($tmp['id']);
            if (isset($tmp['children'])) {
                unset($tmp['children']);
                $b = true;
            } else {
                $b = false;
            }
//            dd( json_encode($tmp) );
            $m = $menu->menuItems()->create(
                $tmp
            );
            if ($b) {
                $this->save($menu, $a['children'][0], $m->id);
            }
        }
    }

    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'info' => 'required|json',
        ]);

        $arr = json_decode($request->input('info'), true);
        $menu->menuItems()->delete();
        $this->save($menu, $arr[0]);
        logAdmin(__METHOD__, Menu::class, $menu->id);
        if ($request->ajax()) {
            return ["OK" => true, 'msg' => "Menu updated"];
        }

        return redirect()->back()
            ->with(['message' => "Menu updated"]);
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();
        logAdmin(__METHOD__, MenuSaveRequest::class, $menu->id);

        return redirect()->back()
            ->with(['message' => "Menu deleted."]);
    }

    public function remItem($item)
    {
        MenuItem::where('id', $item)->delete();
    }
}
