<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\user;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogController extends Controller
{
     public function BlogLists(){

        $id         = Auth::user()->id;
        $adminData  = User::find($id);    
        $title = "Blog Lists Page";
        $blogs  = Blog::latest()->get();
        $Tags = Tag::select('id', 'name')->get();
        $blog_categorys = BlogCategory::select('id', 'name')->get()->toArray();
        $blog_categorys = array_column($blog_categorys, 'name', 'id');
        return view('admin.blogs.All_blogs',compact('blogs','title', 'adminData','blog_categorys','Tags'));

    }//

   public function store(Request $request)
    {

    $validator = \Validator::make($request->all(), [
            'title' => 'required|max:255',
            'tags' => 'required|string',
            'description' => 'required',
            'blog_category_id' => 'required|integer',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:10240',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {

            $imagePath = null;

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
                $imagePath = $file->storeAs('blogs', $filename, 'public');
            }

            $tags = explode(',', $request->tags);
            $tags = array_map('trim', $tags); // remove spaces
            $tags = array_filter($tags); // remove empty
            foreach ($tags as $tag) {
                Tag::firstOrCreate([
                    'name' => trim($tag)
                ]);
            }

            Blog::create([
                'title' => $request->title,
                'tags' => json_encode($tags), // store as JSON (BEST)
                'description' => $request->description,
                'blog_category_id' => $request->blog_category_id,
                'image' => $imagePath,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Blog created successfully!'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage() // for debugging
            ], 500);
        }

    }

    // 🔹 EDIT (optional if using modal)
    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        return response()->json($blog);
    }

    // 🔹 UPDATE
    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $request->validate([
            'title' => 'required|max:255',
            'tags' => 'required',
            'description' => 'required',
            'blog_category_id' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
        ]);

        if ($request->hasFile('image')) {

            // delete old
            if ($blog->image && Storage::disk('public')->exists($blog->image)) {
                Storage::disk('public')->delete($blog->image);
            }

            $file = $request->file('image');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $blog->image = $file->storeAs('blogs', $filename, 'public');
        }

        $blog->update([
            'title' => $request->title,
            'tags' => $request->tags,
            'description' => $request->description,
            'blog_category_id' => $request->blog_category_id,
        ]);

        return redirect()->back()->with('success', 'Blog updated successfully!');
    }

    // 🔹 DELETE
    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);

        if ($blog->image && Storage::disk('public')->exists($blog->image)) {
            Storage::disk('public')->delete($blog->image);
        }

        $blog->delete();

        return redirect()->back()->with('success', 'Blog deleted successfully!');
    }
}
