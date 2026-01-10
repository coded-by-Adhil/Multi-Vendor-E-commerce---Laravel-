<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\About;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Laravel\Facades\Image;

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
}
