<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\About;
use App\Models\User;
use App\Models\MultiImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;


class AboutPageController extends Controller
{
    //

    public function AboutPageContent(){

        $id         = Auth::user()->id;
        $adminData  = User::find($id);    
        $title = "About Page";
        $content_id = 1;
        $About_page_Content = About::find($content_id);

        return view('admin.about_page.about_page',compact('About_page_Content', 'title', 'adminData'));


    }

    public function update(Request $request){


        $validator = Validator::make($request->all(), [
            'title'             => 'required|string|max:255',
            'short_title'       => 'required|string|max:255',
            'short_description' => 'required|string|max:500',
            'long_description'  => 'required|string',
            'about_image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ], [
            'title.required' => 'Slide title is required.',
            'short_title.required' => 'Video URL is required.',
            'short_description.required' => 'long_description description is required.',
            'long_description.required' => 'long_description description is required.',
            'about_image.image' => 'Uploaded file must be an image.',
            'about_image.mimes' => 'Allowed image types: jpg, jpeg, png, webp.',
            'about_image.max' => 'Image size cannot exceed 3MB.',
        ]);

         if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }




        $about = About::firstOrFail();

        if ($request->hasFile('about_image')) {

            if ($about->image_url && Storage::disk('public')->exists($about->image_url)) {
                Storage::disk('public')->delete($about->image_url);
            }

            $file = $request->file('about_image');
            $filename = 'about-' . uniqid() . '.webp';
       
            $image = Image::read($file)
            ->resize(523, 605); 

             Storage::disk('public')->put(
                'about/' . $filename,
                (string) $image->toWebp(80) 
            );


            $about->image_url = 'about/' . $filename;
        }

        $about->update([
            'title'             => $request->title,
            'short_title'       => $request->short_title,
            'short_description' => $request->short_description,
            'long_description'  => $request->long_description,
        ]);

        return redirect()->back()->with('status', 'About page updated successfully!');
    }

    public function HomeAbout(){

        $aboutpage = About::firstOrFail();
        return view('frontend.about_page_files.about_page',compact('aboutpage'));

    }

    public function MultimageUploadView(){

        $id         = Auth::user()->id;
        $adminData  = User::find($id);    
        $title = "About Multiple Image Upload";
        $content_id = 1;
        $About_page_Content = About::find($content_id);

        return view('admin.multi_image_upload_interface',compact('About_page_Content', 'title', 'adminData'));    

    }

     public function store(Request $request)
     {

            $validator = Validator::make($request->all(), [
            'file' => 'required',
            'file.*' => 'image|mimes:jpg,jpeg,png,webp,gif|max:10240',
        ], [
            'file.*.max' => 'One or more images exceed 10MB.',
            'file.*.image' => 'Only image files are allowed.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => $validator->errors()->first()
            ], 422);
        }

        foreach ($request->file('file') as $file) {

            $filename = 'skills-' . uniqid() . '.webp';

            $image = Image::read($file)
                ->resize(220, 220);

            $path = 'skillsimage/' . $filename;

            Storage::disk('public')->put(
                $path,
                (string) $image->toWebp(80)
            );

            MultiImage::create([
                'image_url' => $path,
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Images uploaded successfully!'
        ]);
}


     public function ShowUploadedImages(){

        $id         = Auth::user()->id;
        $adminData  = User::find($id);    
        $title = "Uploaded Images";
        $content_id = 1;
        $images = MultiImage::all();

        return view('admin.show_uploaded_images',compact('images', 'title', 'adminData'));    

     }

     public function DeleteImage($id){
        
        $image = MultiImage::findOrFail($id);

        if ($image->image_url && Storage::disk('public')->exists($image->image_url)) {
            Storage::disk('public')->delete($image->image_url);
        }

        $image->delete();

        return redirect()->back()->with('success', 'Image deleted successfully');
    }



       public function UpdateImage(Request $request, $id)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:10240'
        ]);

        $image = MultiImage::findOrFail($id);

        // Remove old image
        if ($image->image_path && Storage::disk('public')->exists($image->image_path)) {
            Storage::disk('public')->delete($image->image_path);
        }

        // Store new image
        $file = $request->file('image');
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('gallery_images', $filename, 'public');

        // Update DB
        $image->update([
            'image_path' => $path,
            'updated_at' => Carbon::now()
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Image updated successfully',
            'image'  => asset('storage/' . $path)
        ]);
    }
    

}



