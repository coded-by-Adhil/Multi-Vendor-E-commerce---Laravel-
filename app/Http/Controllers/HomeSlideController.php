<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\HomeSlide;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Laravel\Facades\Image;

class HomeSlideController extends Controller
{
    public function HomeSlideContent(){

        $id         = Auth::user()->id;
        $adminData  = User::find($id);    
        $title = "Home Slide";
        $content_id = 1;
        $Home_page_Content = HomeSlide::find($content_id);

        return view('admin.home_slide.home_slide_all',compact('Home_page_Content', 'title', 'adminData'));

    }

    public function update(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'video_url' => 'required|url|max:500',
            'short_description' => 'required|string|max:500',
            'slide_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072', // 3MB
        ], [
            'title.required' => 'Slide title is required.',
            'video_url.required' => 'Video URL is required.',
            'video_url.url' => 'Video URL must be a valid URL.',
            'short_description.required' => 'Short description is required.',
            'slide_image.image' => 'Uploaded file must be an image.',
            'slide_image.mimes' => 'Allowed image types: jpg, jpeg, png, webp.',
            'slide_image.max' => 'Image size cannot exceed 3MB.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $content = HomeSlide::find(1);

        $content->title = $request->title;
        $content->video_url = $request->video_url;
        $content->short_description = $request->short_description;

       if ($request->hasFile('slide_image')) {

            if ($content->banner && Storage::disk('public')->exists($content->banner)) {
                Storage::disk('public')->delete($content->banner);
            }

            $file = $request->file('slide_image');
            $filename = 'home-slide-' . uniqid() . '.webp';

            $image = Image::read($file)
                ->resize(636, 852); 

            Storage::disk('public')->put(
                'home_slides/' . $filename,
                (string) $image->toWebp(80) 
            );

            $content->banner = 'home_slides/' . $filename;
        }

        $content->save();

        return redirect()->back()->with('success', 'Home slide updated successfully!');
    }
}
