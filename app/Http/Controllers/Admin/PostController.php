<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;


class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['category', 'author'])->latest()->get();
        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        // 1. Ambil semua kategori yang aktif dari database
        $categories = PostCategory::where('active', true)->orderBy('name')->get();

        // 2. Kirim variabel $categories tersebut ke view
        return view('admin.posts.create', compact('categories'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:posts,slug',
            'category_id' => 'required|exists:post_categories,id',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'excerpt' => 'nullable|string|max:300',
            'content' => 'required|string',
            'status' => 'required|in:draft,published,archived',
            'headline' => 'nullable|boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        if ($request->hasFile('thumbnail')) {
           $path = $request->file('thumbnail')->store('thumbnails', 'public');
            $validated['thumbnail'] = $path;
        }

        $validated['author_id'] = auth()->id();
        $validated['published_at'] = ($validated['status'] === 'published') ? now() : null;
        $validated['headline'] = $request->has('headline');

        Post::create($validated);

        return redirect()->route('admin.posts.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit(Post $post)
    {
        $categories = PostCategory::where('active', true)->orderBy('name')->get();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('posts')->ignore($post->id)],
            'category_id' => 'required|exists:post_categories,id',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'excerpt' => 'nullable|string|max:300',
            'content' => 'required|string',
            'status' => 'required|in:draft,published,archived',
            'headline' => 'nullable|boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        if ($request->hasFile('thumbnail')) {
            // Hapus thumbnail lama jika ada
            if ($post->thumbnail) {
                Storage::delete($post->thumbnail);
            }
            $path = $request->file('thumbnail')->store('public/thumbnails');
            $validated['thumbnail'] = $path;
        }

        $validated['published_at'] = ($validated['status'] === 'published' && is_null($post->published_at)) ? now() : $post->published_at;
        $validated['headline'] = $request->has('headline');

        $post->update($validated);

        return redirect()->route('admin.posts.index')->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(Post $post)
    {
        if ($post->thumbnail) {
            Storage::delete($post->thumbnail);
        }
        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Berita berhasil dihapus.');
    }
}