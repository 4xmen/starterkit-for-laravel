<?php

namespace Xmen\StarterKit\Controllers\Admin;

use Xmen\StarterKit\Models\Category;
use Xmen\StarterKit\Helpers\TDate;
use App\Http\Controllers\Controller;
use Xmen\StarterKit\Requests\PostSaveRequest;
use Xmen\StarterKit\Models\Post;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use function Xmen\StarterKit\Helpers\logAdmin;
use function Xmen\StarterKit\Helpers\logAdminBatch;

class PostController extends Controller
{

    public function createOrUpdate(Post $news, PostSaveRequest $request)
    {

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
        $news->icon = $request->input('icon');
        if ($news->hash == null) {
            $news->hash = $dt->PDate('Ym') . str_pad(dechex(crc32($news->slug)), 8, '0', STR_PAD_LEFT);
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

    public function bulk(Request $request)
    {

        switch ($request->input('bulk')) {
            case 'delete':
                $msg = __('Post deleted successfully');
                logAdminBatch(__METHOD__ . '.' . $request->input('bulk'), Post::class, $request->input('id'));
                Post::destroy($request->input('id'));
                break;
            case 'draft':
                $msg = __('Post drafted successfully');
                logAdminBatch(__METHOD__ . '.' . $request->input('bulk'), Post::class, $request->input('id'));
                Post::whereIn('id', $request->input('id'))->update(['status' => 0]);
                break;
            case 'publish':
                $msg = __('Post published successfully');
                logAdminBatch(__METHOD__ . '.' . $request->input('bulk'), Post::class, $request->input('id'));
                Post::whereIn('id', $request->input('id'))->update(['status' => 1]);
                break;
            default:
                $msg = __('Unknown bulk action :' . $request->input('bulk'));
        }
        return redirect()->route('admin.post.index')->with(['message' => $msg]);
    }

    public function index(Request $request)
    {
        //
        $n = Post::latest();
        if ($request->has('filter')) {
            $n = $n->where('status', $request->filter);
        }
        $news = $n->paginate(20);
        return view('starter-kit::admin.post.postIndex', compact('news'));
    }

    public function create()
    {
        //
        $cats = Category::all();
        return view('starter-kit::admin.post.postForm', compact('cats'));
    }

    public function store(PostSaveRequest $request)
    {
        //
        $news = new Post();
        $news = $this->createOrUpdate($news, $request);
        logAdmin(__METHOD__, Post::class, $news->id);
        return redirect()->route('admin.post.index')->with(['message' => $news->title . ' ' . __('created successfully')]);
    }

    public function show($id)
    {
        //
    }

    public function edit(Post $news)
    {
        //
        $cats = Category::all();
        return view('starter-kit::admin.post.postForm', compact('cats', 'news'));
    }

    public function update(PostSaveRequest $request, Post $news)
    {
        //
//        return $news;
        $this->createOrUpdate($news, $request);
        logAdmin(__METHOD__, Post::class, $news->id);
        return redirect()->route('admin.post.index')->with(['message' => $news->title . ' ' . __('updated successfully')]);

    }

    public function destroy(Post $news)
    {
        //
        logAdmin(__METHOD__, Post::class, $news->id);
        $news->delete();
        return redirect()->route('admin.post.index')->with(['message' => __('Post deleted successfully')]);
    }
}
