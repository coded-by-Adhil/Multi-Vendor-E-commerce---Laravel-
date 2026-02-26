<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\user;
use App\Models\BlogCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogCategoryController extends Controller
{
    //

    public function AllBlogCategory(){

        $id         = Auth::user()->id;
        $adminData  = User::find($id);    
        $title = "Blog Category Page";
        $blog_categorys  = BlogCategory::latest()->get();
        return view('admin.blog.blog_lists',compact('blog_categorys','title', 'adminData'));

    }


    public function store(Request $request){

        $request->validate([
            'categoryname' => 'required|string|max:255',
        ]);

        BlogCategory::create([
            'name' => $request->categoryname,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Category added successfully'
        ]);
    }

    public function destroy($id){
    
        try {

            $category = BlogCategory::findOrFail($id);
            $category->delete();

            return redirect()->back()->with('success', 'Category deleted successfully');

        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Something went wrong');
        }
    }
}
