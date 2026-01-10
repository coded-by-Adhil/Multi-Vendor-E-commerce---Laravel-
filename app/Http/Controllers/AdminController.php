<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules\Password;


class AdminController extends Controller
{


    public function dashboard(){

        $id         = Auth::user()->id;
        $adminData  = User::find($id);
        $title = "Dashboard"; 
        return view('admin.index', compact('adminData', 'title'));

    }

    public function login(){

       return redirect('/login');

    }


    public function destroy(Request $request): RedirectResponse{
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }//End Method


    public function profile(){

        $id         = Auth::user()->id;
        $adminData  = User::find($id); 
        $title = "Profile"; 
        return view('admin.admin_profile_view', compact('adminData', 'title'));

    }

    public function passwordChange(){

        $id         = Auth::user()->id;
        $adminData  = User::find($id); 
        $title = "Security Settings"; 
        return view('admin.admin_change_password', compact('adminData', 'title'));

    }

    public function updatePassword(Request $request){

    $user = Auth::user();
    $id         = Auth::user()->id;
    $adminData  = User::find($id); 
   
      $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

    // if (!Hash::check($request->current_password, $user->password)) {
    //     throw ValidationException::withMessages([
    //         'current_password' => 'Current password is incorrect.',
    //     ]);
    // }

    if (Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'password' => 'New password cannot be the same as current password.',
        ]);
    }

    $user->password = Hash::make($request->password);
    $user->save();
    $status = "Password updated successfully!";
    $title = "Security Settings";  
    return view('admin.admin_change_password', compact('adminData', 'title', 'status'));
}



    public function update(Request $request){

        $user = Auth::user();

        // --- 1. Manual validation to capture errors and return JSON ---
        $validator = Validator::make($request->all(), [
            'name'  => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072', // 3MB max
        ], [
            'name.required' => 'Name cannot be empty.',
            'name.max' => 'Name cannot exceed 255 characters.',
            'image.image' => 'Uploaded file must be an image.',
            'image.mimes' => 'Allowed image types: jpg, jpeg, png, webp.',
            'image.max' => 'Image size cannot exceed 3MB.',
        ]);

        if ($validator->fails()) {
            // Return JSON with all validation errors
            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => $validator->errors()->first(), // first error
                'errors' => $validator->errors() // all errors if needed
            ], 422);
        }

        try {
            // --- 2. Update name ---
            $user->name = $request->name;

            // --- 3. Handle image upload ---
            if ($request->hasFile('image')) {
                $file = $request->file('image');

                // Delete old image if exists
                if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
                    Storage::disk('public')->delete($user->profile_image);
                }

                // Store new image
                $path = $file->store('profiles', 'public');
                $user->profile_image = $path;
            }

            // --- 4. Save user ---
            $user->save();

            // --- 5. Return JSON with success and redirect URL ---
            return response()->json([
                'success' => true,
                'status' => 'success',
                'message' => 'Profile updated successfully!',
                'redirect' => route('admin.profile'), // frontend can redirect
                'name' => $user->name,
                'image' => $user->profile_image ? asset('storage/' . $user->profile_image) : null,
            ]);

        } catch (\Exception $e) {
            // --- 6. Catch unexpected server errors ---
            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }


    
}
