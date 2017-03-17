<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use App\User;
use Validation;
use Auth;
class UserController extends Controller
{
    public function ShowSettingsForm(Request $request) {
        $themes = Storage::files('themes');
        return view('auth.settings')->with(['themes'=>$themes]);
    }
    public function SubmitSettingsForm(Request $request) {
        $this->validate($request, [
            'password' => 'confirmed|min:6',
        ]);
        $user = Auth::user();
        $user->password = bcrypt($request->password);
        $user->save();
        return redirect('settings');
    }
    public function SubmitSettingsTheme(Request $request){
        $user = Auth::user();
        $user->theme = $request->theme;
        $user->save();
        return redirect('settings');
    }
}
