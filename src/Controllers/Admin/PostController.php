<?php

namespace Xmen\StarterKit\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use function Xmen\StarterKit\Helpers\logAdmin;
use function Xmen\StarterKit\Helpers\logAdminBatch;
use Xmen\StarterKit\Helpers\TDate;
use Xmen\StarterKit\Models\Category;
use Xmen\StarterKit\Models\Post;
use Xmen\StarterKit\Requests\PostSaveRequest;

class PostController extends Controller
{
    public function createOrUpdate(Post $post, PostSaveRequest $request)
    {
        $dt = new TDate();

        $post->title = $request->input('title');
        $post->slug = \StarterKit::slug($request->input('title'));
        $post->body = $request->input('body');
        $post->subtitle = $request->input('subtitle');
        $post->status = $request->input('status');
        $post->category_id = $request->input('category_id');
        $post->user_id = auth()->id();
        $post->is_breaking = $request->has('is_breaking');
        $post->is_pinned = $request->has('is_pinned');
        $post->icon = $request->input('icon');
        if ($post->hash == null) {
            $post->hash = $dt->PDate('Ym') . str_pad(dechex(crc32($post->slug)), 8, '0', STR_PAD_LEFT);
        }

        $post->save();

        $post->retag(explode(',', $request->input('tags')));

        $post->categories()->sync($request->input('cat'));


        if ($request->hasFile('image')) {
            $post->media()->delete();
            $post->addMedia($request->file('image'))->toMediaCollection();
        }


//        foreach ($post->getMedia() as $media) {
//            in_array($media->id, request('medias', [])) ?: $media->delete();
//        }
//        foreach ($request->file('images', []) as $image) {
//            try {
//                $post->addMedia($image)->toMediaCollection();
//            } catch (FileDoesNotExist $e) {
//            } catch (FileIsTooBig $e) {
//            }
//        }

        return $post;
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
        $posts = $n->paginate(20);

        return view('starter-kit::admin.post.postIndex', compact('posts'));
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
        $post = new Post();
        $post = $this->createOrUpdate($post, $request);
        logAdmin(__METHOD__, Post::class, $post->id);

        return redirect()->route('admin.post.index')->with(['message' => $post->title . ' ' . __('created successfully')]);
    }

    public function show($id)
    {
        //
    }

    public function edit(Post $posts)
    {
        $cats = Category::all();

        return view('starter-kit::admin.post.postForm', compact('cats', 'posts'));
    }

    public function update(PostSaveRequest $request, Post $post)
    {
        $this->createOrUpdate($post, $request);
        logAdmin(__METHOD__, Post::class, $post->id);

        return redirect()->route('admin.post.index')->with(['message' => $post->title . ' ' . __('updated successfully')]);
    }

    public function destroy(Post $post)
    {
        //
        logAdmin(__METHOD__, Post::class, $post->id);
        $post->delete();

        return redirect()->route('admin.post.index')->with(['message' => __('Post deleted successfully')]);
    }
}
