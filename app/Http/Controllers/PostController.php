<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
// use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Log;
// use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    // public function index()
    // {
    //     Log::info('PostController@indexが実行されました');
    //     // $posts = Post::all();
    //     // $posts = Post::where('user_id', auth()->id())->get();
    //     $posts = Post::paginate(10);
    //     return view('post.index', compact('posts'));
    // }
    public function index(Request $request)
    {
        $query = Post::query();
        if ($request->has('search')) {
            // 半角スペースで分割し、配列に格納
            $searchwords = explode(' ', $request->search);
            // 配列の要素をループで取り出し、クエリに追加
            foreach ($searchwords as $searchword) {
                $query->where('title', 'like', '%' . $searchword . '%');
            }
            Log::info('タイトルで検索しました');
        }
        if ($request->has('sort') && $request->sort == 'title') {
            $query->orderBy('title');
            Log::info('タイトルでソートしました');
        } elseif ($request->has('sort') && $request->sort == 'created_at') {
            $query->orderBy('created_at', 'asc');
            Log::info('作成日時でソートしました');
        } else {
            $query->orderBy('created_at', 'desc');
        }
        $posts = $query->paginate(10);
        return view('post.index', compact('posts'));
    }

    public function create()
    {
        return view('post.create');
    }

    public function store(Request $request)
    {
        Log::info('PostController@storeが実行されました');
        // Gate::authorize('test');
        $validated = $request->validate([
            'title' => 'required|max:20',
            'body' => 'required|max:400',
        ]);

        $validated['user_id'] = auth()->id();
        $post = Post::create($validated);
        $request->session()->flash('message', '保存しました');
        return back();
    }

    public function show(Post $post)
    {
        return view('post.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $post->body = trim($post->body);
        Log::info('PostController@editが実行されました: ' . $post->body);
        return view('post.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|max:20',
            'body' => 'required|max:400',
        ]);

        $post->update($validated);
        $request->session()->flash('message', '更新しました');
        return back();
    }

    public function destroy(Request $request, Post $post)
    {
        $post->delete();
        $request->session()->flash('message', '削除しました');
        return redirect()->route('post.index');
    }
}
