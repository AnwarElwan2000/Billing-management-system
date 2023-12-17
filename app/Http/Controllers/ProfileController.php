<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */

     public function show(){
        return view('profile.show_profile');
     }


    public function edit(Request $request): View
    {
        return view('profile.ProfileUpdate', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }


    public function update_profile(Request $request){

        // $validate = $request->validate([
        //    'name' => 'required|max:255',
        //    'email' => 'required|max:255|unique:users',
        //    'password' => 'required|min:8|max:30',
        //    'img' => 'mimes:png,jpeg,gif,jpg,pdf',
        // ]);


         $user_id = User::find($request->user_id);
     
        if($request->hasfile('img')) {
         $img = $request->file('img');
         $image_name = $img->getClientOriginalName();

         $user_id->name = $request->name;
         $user_id->email = $request->email;
         $user_id->password = $request->password;
         $user_id->upload_img = $image_name;
         foreach($user_id->roles_name as $roles){
            if($roles === "owner"){
                $request->img->move(public_path('owner_img/') ,  $image_name );
            }else{
                $request->img->move(public_path('user_img/') ,  $image_name );
             }
         }

        }else{
            $user_id->name = $request->name;
            $user_id->email = $request->email;
            $user_id->password = $request->password;
        }

        $user_id->save();
        session()->flash('update_profile');
         return back();
     
    }

}
