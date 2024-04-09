<?php

namespace Xmen\StarterKit\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use function Xmen\StarterKit\Helpers\logAdmin;

use function Xmen\StarterKit\Helpers\logAdminBatch;
use Xmen\StarterKit\Models\Category;
use Xmen\StarterKit\Requests\CategorySaveRequest;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function createOrUpdate(Category $cat, CategorySaveRequest $request)
    {
        $cat->name = $request->input('name');
        $cat->slug = \StarterKit::slug($request->input('name'));
        $cat->description = $request->input('description');
        $cat->subtitle = $request->input('subtitle');
        $cat->parent_id = $request->input('parent') == '' ? null : $request->input('parent');
        $cat->save();

        return $cat;
    }


    public function bulk(Request $request)
    {
        switch ($request->input('bulk')) {
            case 'delete':
                $msg = __('Categories deleted successfully');
                logAdminBatch(__METHOD__ . '.' . $request->input('bulk'), Category::class, $request->input('id'));
                Category::destroy($request->input('id'));

                break;
            default:
                $msg = __('Unknown bulk action :' . $request->input('bulk'));
        }

        return redirect()->route('admin.category.index')->with(['message' => $msg]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cats = Category::paginate(20);

        return view('starter-kit::admin.category.categoryIndex', compact('cats'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cats = Category::all();

        return view('starter-kit::admin.category.categoryForm', compact('cats'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategorySaveRequest $request)
    {
        $cat = new Category();
        $cat = $this->createOrUpdate($cat, $request);
        logAdmin(__METHOD__, Category::class, $cat->id);

        return redirect()->route('admin.category.index')->with(['message' => __('Category created successfully')]);
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
    public function edit(Category $cat)
    {
        $cats = Category::where('id', '<>', $cat->id)->get();
        $ccat = $cat;

        return view('starter-kit::admin.category.categoryForm', compact('ccat', 'cats'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategorySaveRequest $request, Category $cat)
    {
        $this->createOrUpdate($cat, $request);
        logAdmin(__METHOD__, Category::class, $cat->id);

        return redirect()->route('admin.category.index')->with(['message' => __('Category updated successfully')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $cat)
    {
        logAdmin(__METHOD__, Category::class, $cat->id);
        $cat->delete();

        return redirect()->route('admin.category.index')->with(['message' => __('Category deleted successfully')]);
    }

    public function sort()
    {
        $cats = Category::orderBy('sort')->whereNull('parent_id')->get();

        return view('starter-kit::admin.category.categorySort', compact('cats'));
    }

    public function sortStore(Request $request)
    {
        $request->validate([
            'info' => 'required|json'
        ]);
        $arr = json_decode($request->input('info'), true);
        $this->saveSort($arr[0]);
        logAdmin(__METHOD__, Cat::class, '0');
        if ($request->ajax()) {
            return ["OK" => true, 'msg' => "Categories sort updated"];
        }
        return redirect()->back()
            ->with(['message' => "Categories sort updated"]);
    }

    public function saveSort($arr, $parent = null)
    {
        foreach ($arr as $key => $value) {
            $cat = Category::whereId($value['id'])->first();
            $cat->sort = $key;
            $cat->parent_id = $parent;
            $cat->save();
            if (isset($value['children']) && count($value['children'][0]) > 0) {
                $this->saveSort($value['children'][0], $value['id']);
            }
        }
    }
}
