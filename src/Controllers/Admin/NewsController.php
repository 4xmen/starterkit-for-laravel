<?php

namespace Xmen\StarterKit\Controllers\Admin;

use Xmen\StarterKit\Models\Category;
use Xmen\StarterKit\Helpers\TDate;
use App\Http\Controllers\Controller;
use Xmen\StarterKit\Requests\NewsSaveRequest;
use Xmen\StarterKit\Models\News;

use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use function Xmen\StarterKit\Helpers\logAdmin;
use function Xmen\StarterKit\Helpers\logAdminBatch;

class NewsController extends Controller {

    public function createOrUpdate(News $news, NewsSaveRequest $request) {

        $dt = new TDate();

        $news->title = $request->input('title');
        $news->slug = \StarterKit::slug($request->input('title'));
        $news->body = $request->input('body');
        $news->subtitle = $request->input('subtitle');
        $news->status = $request->input('status');
        $news->category_id = $request->input('category_id');
        $news->user_id = auth()->id();
        $news->is_breaking = $request->has('is_breaking');
        $news->is_pinned = $request->has('is_pinned');
        if ($news->hash == null) {
            $news->hash = $dt->PDate('Ym') .str_pad(dechex(crc32($news->slug)), 8, '0', STR_PAD_LEFT);
        }

        $news->save();

        $news->retag(explode(',', $request->input('tags')));

        $news->categories()->sync($request->input('cat'));


        if ($request->hasFile('image')) {
            $news->media()->delete();
            $news->addMedia($request->file('image'))->toMediaCollection();
        }


//        foreach ($news->getMedia() as $media) {
//            in_array($media->id, request('medias', [])) ?: $media->delete();
//        }
//        foreach ($request->file('images', []) as $image) {
//            try {
//                $news->addMedia($image)->toMediaCollection();
//            } catch (FileDoesNotExist $e) {
//            } catch (FileIsTooBig $e) {
//            }
//        }

        return $news;
    }

    public function bulk(Request $request) {

        switch ($request->input('bulk')) {
            case 'delete':
                $msg = __('News deleted successfully');
                logAdminBatch(__METHOD__.'.'.$request->input('bulk'),News::class,$request->input('id'));
                News::destroy($request->input('id'));
                break;
            case 'draft':
                $msg = __('News drafted successfully');
                logAdminBatch(__METHOD__.'.'.$request->input('bulk'),News::class,$request->input('id'));
                News::whereIn('id', $request->input('id'))->update(['status' => 0]);
                break;
            case 'publish':
                $msg = __('News published successfully');
                logAdminBatch(__METHOD__.'.'.$request->input('bulk'),News::class,$request->input('id'));
                News::whereIn('id', $request->input('id'))->update(['status' => 1]);
                break;
            default:
                $msg = __('Unknown bulk action :' . $request->input('bulk'));
        }
        return redirect()->route('admin.news.index')->with(['message' => $msg]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        //
        $n = News::latest();
        if ($request->has('filter')){
            $n = $n->where('status',$request->filter);
        }
        $news = $n->paginate(20);
        return view('starter-kit::admin.news.NewsIndex', compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
        $cats = Category::all();
        return view('starter-kit::admin.news.newsForm', compact('cats'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewsSaveRequest $request) {
        //
        $news = new News();
        $news = $this->createOrUpdate($news, $request);
        logAdmin(__METHOD__,News::class,$news->id);
        return redirect()->route('admin.news.index')->with(['message' => $news->title . ' ' . __('created successfully')]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(News $news) {
        //
        $cats = Category::all();
        return view('starter-kit::admin.news.newsForm', compact('cats', 'news'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(NewsSaveRequest $request, News $news) {
        //
//        return $news;
        $this->createOrUpdate($news, $request);
        logAdmin(__METHOD__,News::class,$news->id);
        return redirect()->route('admin.news.index')->with(['message' => $news->title . ' ' . __('updated successfully')]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(News $news) {
        //
        logAdmin(__METHOD__,News::class,$news->id);
        $news->delete();
        return redirect()->route('admin.news.index')->with(['message' => __('News deleted successfully')]);
    }
}
