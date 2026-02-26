<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Portfolio;
use App\Models\user;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class PortfolioController extends Controller
{
    //

    public function AllPortfolio(){

        $portfolio  = Portfolio::latest()->get();
        $id         = Auth::user()->id;
        $adminData  = User::find($id);    
        $title      = "All Portfolio";
        return view('admin.portfolio.All_portfolio',compact('portfolio','adminData','title'));

    }

    public function AddPortfolio(){

        $id         = Auth::user()->id;
        $adminData  = User::find($id);    
        $title      = "Add Portfolio";
        $portfolio  = "";
        return view('admin.portfolio.Add_portfolio',compact('portfolio','adminData','title'));

    }



    public function StorePortfolio(Request $request){

    $validator = \Validator::make($request->all(), [
        'portfolio_name'        => 'required|string|max:255',
        'portfolio_title'       => 'required|string|max:255',
        'portfolio_description' => 'required|string',
        'portfolio_image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    try {

        $imagePath = null;

        if ($request->hasFile('portfolio_image')) {
            $file = $request->file('portfolio_image');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $imagePath = $file->storeAs('portfolio_images', $filename, 'public');
        }

        Portfolio::create([
            'portfolio_name'        => $request->portfolio_name,
            'portfolio_title'       => $request->portfolio_title,
            'portfolio_description' => $request->portfolio_description,
            'portfolio_image'       => $imagePath,
        ]);

        return redirect()->back()
            ->with('success', 'Portfolio created successfully!');

    } catch (\Exception $e) {

        return redirect()->back()
            ->with('error', 'Something went wrong. Please try again.');
    }
}

    public function EditPortfolio($id)
    {
        $user_id    = Auth::user()->id;
        $adminData  = User::find($user_id);    
        $title      = "Edit Portfolio";
        $portfolio  = Portfolio::findOrFail($id);
        return view('admin.portfolio.Add_portfolio',compact('portfolio','adminData','title'));
    }


    public function UpdatePortfolio(Request $request, $id){

        $validator = \Validator::make($request->all(), [
            'portfolio_name'        => 'required|string|max:255',
            'portfolio_title'       => 'required|string|max:255',
            'portfolio_description' => 'required|string',
            'portfolio_image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {

            $portfolio = Portfolio::findOrFail($id);

            $imagePath = $portfolio->portfolio_image;

            if ($request->hasFile('portfolio_image')) {
                $file = $request->file('portfolio_image');
                $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
                $imagePath = $file->storeAs('portfolio_images', $filename, 'public');
            }

            $portfolio->update([
                'portfolio_name'        => $request->portfolio_name,
                'portfolio_title'       => $request->portfolio_title,
                'portfolio_description' => $request->portfolio_description,
                'portfolio_image'       => $imagePath,
            ]);

            return redirect()->back()
                ->with('success', 'Portfolio updated successfully!');

        } catch (\Exception $e) {

            return redirect()->back()
                ->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function DeletePortfolio($id)
    {
        try {

            $portfolio = Portfolio::findOrFail($id);

            if ($portfolio->portfolio_image && \Storage::disk('public')->exists($portfolio->portfolio_image)) {
                \Storage::disk('public')->delete($portfolio->portfolio_image);
            }

            $portfolio->delete();

            return redirect()->back()
                ->with('success', 'Portfolio deleted successfully!');

        } catch (\Exception $e) {

            return redirect()->back()
                ->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function PortfolioDetails($id){

        $portfolio = Portfolio::findOrFail($id);
        return view('frontend.Home_page_files.portfolio_details',compact('portfolio'));


    }


}
